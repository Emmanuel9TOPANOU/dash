<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\EmployeAuthController;
use App\Http\Controllers\EmployeDashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EmployeAbsenceController;
use App\Http\Controllers\EmployeTaskController;
use App\Http\Controllers\EmployeReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommercialDocumentController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\EmployeAttendanceController;
use App\Http\Controllers\AdministrationDashboardController;
use App\Http\Controllers\Administration\RhController;
use App\Http\Controllers\Administration\CompanySettingController;
use App\Http\Controllers\Administration\CommunicationTaskController;
use App\Http\Controllers\GlobalMessageController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\NotificationController;

// =======================
// Pages principales
// =======================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// =======================
// Espace administrateur
// =======================
Route::middleware(['auth', 'admin.activity'])->group(function () {

    // Profil administrateur
    Route::get('/admin/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
    Route::put('/admin/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::put('/admin/profile/password', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.password');

    // Gestion des services
    Route::resource('services', ServiceController::class);

    // Profil utilisateur standard
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Gestion des employés
    Route::resource('employees', EmployeeController::class);

    // Module Gestion Commerciale & Financière (Section 10)
    Route::get('/commercial/{document}/pdf', [CommercialDocumentController::class, 'downloadPdf'])->name('commercial.pdf');
    Route::get('/commercial/{document}/pdf-alias', [CommercialDocumentController::class, 'downloadPdf'])->name('commercial-documents.pdf');

    // Resource principale
    Route::resource('commercial', CommercialDocumentController::class);

    // Alias de resource pour assurer la compatibilité avec commercial-documents.*
    Route::resource('commercial-documents', CommercialDocumentController::class);

    // Gestion des dépenses (Section 10)
    Route::resource('expenses', ExpenseController::class);

    // Gestion des présences
    Route::resource('attendances', AttendanceController::class);
    Route::post('attendance/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clockin');
    Route::post('attendance/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clockout');

    // Gestion des absences
    Route::resource('absences', AbsenceController::class);

    // Gestion des tâches
    Route::resource('tasks', TaskController::class);

    // Gestion des clients et projets
    Route::resource('clients', ClientController::class)->except(['show']);
    Route::resource('projects', ProjectController::class)->except(['show']);

    // Gestion des rapports et exports comptables/RH
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/pdf', [ReportController::class, 'generatePdf'])->name('reports.pdf');
    Route::get('/reports/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');
});

require __DIR__ . '/auth.php';

// =======================
// Espace employé
// =======================

// Authentification employé
Route::get('employe/register', [EmployeAuthController::class, 'showRegisterForm'])->name('employe.register');
Route::post('employe/register', [EmployeAuthController::class, 'register'])->name('employe.register.submit');

Route::get('employe/login', [EmployeAuthController::class, 'showLoginForm'])->name('employe.login');
Route::post('employe/login', [EmployeAuthController::class, 'login'])->name('employe.login.submit');

Route::get('employe/logout', [EmployeAuthController::class, 'logout'])->name('employe.logout');

// Tableau de bord employé
Route::get('employe/dashboard', [EmployeDashboardController::class, 'index'])->name('employe.dashboard');
Route::get('employe/profile', [EmployeDashboardController::class, 'profile'])->name('employe.profile');
Route::get('employe/presences', [EmployeDashboardController::class, 'presences'])->name('employe.presences');

// Pointage employé
Route::post('/employe/clock-in', [AttendanceController::class, 'clockIn'])->name('employe.clockin');
Route::post('/employe/clock-out', [AttendanceController::class, 'clockOut'])->name('employe.clockout');

// Gestion des présences employé
Route::get('/presences', [EmployeAttendanceController::class, 'index'])->name('presences');

// Gestion des absences employé
Route::get('employe/absences', [EmployeAbsenceController::class, 'index'])->name('employe.absences.index');
Route::get('employe/absences/create', [EmployeAbsenceController::class, 'create'])->name('employe.absences.create');
Route::post('employe/absences', [EmployeAbsenceController::class, 'store'])->name('employe.absences.store');

// Gestion des tâches employé
Route::get('employe/taches', [EmployeTaskController::class, 'index'])->name('employe.taches.index');
Route::post('employe/taches/{task}/done', [EmployeTaskController::class, 'markAsDone'])->name('employe.taches.done');

// Gestion des rapports employé
Route::get('employe/rapports', [EmployeReportController::class, 'index'])->name('employe.rapports.index');
Route::get('employe/rapports/pdf', [EmployeReportController::class, 'exportPdf'])->name('employe.rapports.pdf');

Route::put('employe/profile/update', [EmployeDashboardController::class, 'updateProfile'])->name('employe.profile.update');

// =======================
// Espace Administration
// =======================

// Dashboard principal administration
Route::get('administration/dashboard', [EmployeDashboardController::class, 'adminDashboard'])->name('administration.dashboard');

// Gestion des employés (Espace RH)
Route::prefix('administration/rh')
    ->name('administration.rh.')
    ->group(function () {

        Route::get('/dashboard', [RhController::class, 'dashboard'])->name('dashboard');

        Route::get('/attendances', [RhController::class, 'attendances'])->name('attendances');
        Route::get('/attendances/{attendance}', [RhController::class, 'showAttendance'])->name('attendances.show');

        Route::get('/absences', [RhController::class, 'absences'])->name('absences');
        Route::get('/absences/{absence}', [RhController::class, 'showAbsence'])->name('absences.show');

        Route::get('/employees/create', [RhController::class, 'createEmployee'])->name('employees.create');
        Route::post('/employees/store', [RhController::class, 'storeEmployee'])->name('employees.store');
        Route::get('/employees', [RhController::class, 'employees'])->name('employees');
        Route::get('/employees/{employee}', [RhController::class, 'employeeShow'])->name('employees.show');

        // Liste et gestion de la paie
        Route::get('/paie', [\App\Http\Controllers\Administration\RhPayrollController::class, 'index'])->name('paie.index');
        Route::get('/paie/create', [\App\Http\Controllers\Administration\RhPayrollController::class, 'create'])->name('paie.create');
        Route::post('/paie/generate', [\App\Http\Controllers\Administration\RhPayrollController::class, 'generate'])->name('paie.generate');
        Route::get('/paie/{id}/download', [\App\Http\Controllers\Administration\RhPayrollController::class, 'download'])->name('paie.download');
    });

// Paramètres de l'entreprise
Route::middleware('auth')
    ->prefix('administration/settings')
    ->name('administration.settings.')
    ->group(function () {
        Route::get('/', [CompanySettingController::class, 'index'])->name('index');
        Route::post('/update', [CompanySettingController::class, 'update'])->name('update');
    });

// Espace Communication
Route::prefix('administration/communication/tasks')
    ->name('administration.communication.tasks.')
    ->group(function () {
        Route::get('/', [CommunicationTaskController::class, 'index'])->name('index');
        Route::get('/create', [CommunicationTaskController::class, 'create'])->name('create');
        Route::post('/store', [CommunicationTaskController::class, 'store'])->name('store');
        Route::get('/{task}/edit', [CommunicationTaskController::class, 'edit'])->name('edit');
        Route::put('/{task}', [CommunicationTaskController::class, 'update'])->name('update');
        Route::delete('/{task}', [CommunicationTaskController::class, 'destroy'])->name('destroy');
    });

Route::get('/messagerie', [GlobalMessageController::class, 'index'])->name('messagerie.index');
Route::post('/messagerie/send', [GlobalMessageController::class, 'store'])->name('messagerie.send');

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark_read');
    Route::post('/notifications/mark-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark_all_read');
});
