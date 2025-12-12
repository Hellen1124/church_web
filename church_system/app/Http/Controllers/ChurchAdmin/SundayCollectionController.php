<?php

namespace App\Http\Controllers\ChurchAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
 
class SundayCollectionController extends Controller
{
    /**
     * Display a listing of the members.
     */
    public function index()
    {
        return view('churchadmin.sundaycollection.index');
    }

    // Additional methods (create, store, show, edit, update, destroy) can be added here as needed.
   
    public function create()
    {
        return view('churchadmin.offerings.create');

    }
    
}