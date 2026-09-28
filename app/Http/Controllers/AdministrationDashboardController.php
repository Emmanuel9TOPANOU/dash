<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministrationDashboardController extends Controller
{
    public function index()
    {
        return view('administration.dashboard');
    }
}
