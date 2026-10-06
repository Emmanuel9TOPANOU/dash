<?php

namespace App\Http\Middleware;

use App\Models\Log;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogAdminActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $actor = $request->user();
        $response = $next($request);

        if (!$actor instanceof User || !$this->isWriteRequest($request) || $response->getStatusCode() >= 400) {
            return $response;
        }

        if (
            $request->hasSession()
            && ($request->session()->has('errors') || $request->session()->has('error'))
        ) {
            return $response;
        }

        $routeName = $request->route()?->getName();

        if ($routeName && str_starts_with($routeName, 'notifications.')) {
            return $response;
        }

        [$action, $type] = $this->describe($request, $routeName);

        Log::create([
            'user_id' => $actor->id,
            'actor_id' => $actor->id,
            'actor_type' => User::class,
            'action' => $action,
            'type' => $type,
            'ip' => $request->ip(),
        ]);

        return $response;
    }

    private function isWriteRequest(Request $request): bool
    {
        return in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'], true);
    }

    private function describe(Request $request, ?string $routeName): array
    {
        $segments = explode('.', $routeName ?? trim($request->path(), '/'));
        $operation = strtolower((string) end($segments));

        $action = match ($operation) {
            'store', 'create' => 'Création',
            'update', 'edit' => 'Mise à jour',
            'destroy', 'delete' => 'Suppression',
            'logout' => 'Déconnexion',
            'login' => 'Connexion',
            default => match ($request->method()) {
                'POST' => 'Action effectuée',
                'PUT', 'PATCH' => 'Mise à jour',
                'DELETE' => 'Suppression',
                default => 'Action effectuée',
            },
        };

        $subjectLabels = [
            'admin' => 'profil administrateur',
            'profile' => 'profil',
            'employees' => 'employés',
            'absences' => 'absences',
            'attendances' => 'présences',
            'attendance' => 'présence',
            'tasks' => 'tâches',
            'clients' => 'clients',
            'projects' => 'projets',
            'services' => 'services',
            'expenses' => 'dépenses',
            'commercial' => 'documents commerciaux',
            'messagerie' => 'messagerie',
            'password' => 'mot de passe',
            'settings' => 'paramètres',
            'register' => 'compte administrateur',
        ];

        $subject = 'plateforme';
        foreach (array_reverse($segments) as $segment) {
            if (isset($subjectLabels[$segment])) {
                $subject = $subjectLabels[$segment];
                break;
            }
        }

        if (in_array($operation, ['login', 'logout'], true)) {
            $subject = 'système';
        }

        return ["{$action} : {$subject}", $subject];
    }
}
