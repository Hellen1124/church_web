<?php

namespace App\Http\Controllers\ChurchAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    /**
     * Display the Church Admin Dashboard.
     */
    public function index()
    {
        return view('churchadmin.dashboard.index');
    }
   
}