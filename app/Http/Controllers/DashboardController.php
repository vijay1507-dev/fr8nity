<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.dashboard');
    }

    public function profile()
    {
        return view('dashboard.profile');
    }
    public function editprofile()
    {
        return view('dashboard.editprofile');
    }
}