@extends('layouts.appdashadmin')
@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Nouveau projet</h2>
            <p class="mt-1 text-sm text-gray-500">Créez un projet et rattachez-le à un client.</p>
        </div>
        <form method="POST" action="{{ route('projects.store') }}"
            class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">@include('administration.projects._form')</form>
    </div>
@endsection
