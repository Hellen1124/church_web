<?php

namespace App\Http\Controllers\ChurchAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the expenses.
     */
    public function index()
    {
        return view('churchadmin.expenses.index');
    }

    // Additional methods (create, store, show, edit, update, destroy) can be added here as needed.
   
    public function create()
    {
        return view('churchadmin.expenses.create');

    }
    
}