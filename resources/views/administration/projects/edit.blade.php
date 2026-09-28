@extends('layouts.appdashadmin')
@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Modifier le projet</h2>
            <p class="mt-1 text-sm text-gray-500">Mettez à jour les informations et l’avancement.</p>
        </div>
        <form method="POST" action="{{ route('projects.update', $project) }}"
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">@method('PUT') @include('administration.projects._form')
        </form>
    </div>
@endsection
