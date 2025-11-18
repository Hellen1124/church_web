<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    /**
     * Display the Super Admin Dashboard.
     */
    public function index()
    {
        return view('superadmin.dashboard.index');
    }
   
}