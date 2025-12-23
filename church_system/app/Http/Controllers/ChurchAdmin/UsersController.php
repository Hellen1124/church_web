<?php

namespace App\Http\Controllers\ChurchAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Member;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('churchadmin.createuser.create');
    }

   // index method can be added here later for listing users if needed
   public function index()
   {
       $users = User::all();
       return view('churchadmin.createuser.index', compact('users'));
   }
}