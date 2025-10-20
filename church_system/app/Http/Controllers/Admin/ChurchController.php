<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Church;

class ChurchController extends Controller
{
    /**
     * Display a listing of all registered churches.
     * The logic (pagination, filtering, search) lives in Livewire\Churches\ChurchList.
     */
    public function index()
    {
        return view('admin.churches.index'); 
        // → Blade view only contains: <livewire:churches.church-list />
    }

    /**
     * Show the form for creating a new church.
     * The creation logic and validation are handled inside Livewire\Churches\ChurchCreate.
     */
    public function create()
    {
        return view('admin.churches.create'); 
        // → <livewire:churches.church-create />
    }

    /**
     * Display details for a specific church.
     * The Livewire component handles the dynamic loading of data, members, etc.
     */
    public function show(Church $church)
    {
        return view('admin.churches.show', compact('church'));
        // → <livewire:churches.church-show :church="$church" />
    }
}
