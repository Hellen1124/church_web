<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant ;

class ChurchController extends Controller
{
    
     
     //The logic (pagination, filtering, search) lives in Livewire\Churches\ChurchList.
     
    public function index()
    {
        return view('superadmin.church.index'); 
       
    }

    
     // The creation logic and validation are handled inside Livewire\Churches\ChurchCreate.
     
    public function create()
    {
        return view('superadmin.church.create'); 
        
    }

   
     //The Livewire component handles the dynamic loading of data, members, etc.
     
    public function show(Tenant $church)
    {
        return view('superadmin.church.show', compact('church'));
        
    }
}
