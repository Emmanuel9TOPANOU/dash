<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    public function index()
    {
        $settings = CompanySetting::first();
        return view('administration.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = CompanySetting::first() ?? new CompanySetting();

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email',
            'rccm' => 'nullable|string|max:255',
            'ifu' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'primary_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'secondary_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'text_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('company', 'public');
        }

        $settings->fill($validated)->save();

        return back()->with('success', 'Informations mises à jour avec succès ✔️');
    }
}
