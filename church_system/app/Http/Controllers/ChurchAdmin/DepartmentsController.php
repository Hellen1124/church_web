<?php

namespace App\Http\Controllers\ChurchAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentsController extends Controller
{

    // create method
    public function create()
    {
        return view('churchadmin.department.create');
    }

    /**
     * Display the Church Admin Dashboard.
     */
    public function index()
    {
        return view('churchadmin.department.index');
    }
   
}
