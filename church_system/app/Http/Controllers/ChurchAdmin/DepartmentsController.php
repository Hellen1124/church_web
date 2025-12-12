<?php

namespace App\Http\Controllers\ChurchAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;

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
   
    // Edit method
    public function edit(Department $department)
    {
        return view('churchadmin.department.edit', compact('department'));
    }
}
