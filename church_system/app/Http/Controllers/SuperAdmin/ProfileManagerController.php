<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileManagerController extends Controller
{
    public function show()
    {
        return view('superadmin.profile.show'); 
    }
}