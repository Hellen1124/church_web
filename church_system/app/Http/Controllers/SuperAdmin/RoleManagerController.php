<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Role;

class RoleManagerController extends Controller
{
    public function index()
    {
        return view('superadmin.rolemanager.index');
    }
}