<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('student')) {
            return view('dashboard.student');
        } elseif ($user->hasRole('lecturer')) {
            return view('dashboard.lecturer');
        } elseif ($user->hasRole('admin')) {
            return view('dashboard.admin');
        }

        return abort(403, 'Unauthorized action.');
    }
}
