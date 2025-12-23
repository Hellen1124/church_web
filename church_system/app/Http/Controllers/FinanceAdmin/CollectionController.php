<?php

namespace App\Http\Controllers\FinanceAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CollectionController extends Controller
{

    /**
     * Display the Finance Admin Dashboard.
     */
    public function index()
    {
        return view('financeadmin.collections.index');
    }
   
}