<?php
namespace App\Http\Controllers\ChurchAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
 
class OfferingsController extends Controller
{
    /**
     * Display a listing of the members.
     */
    public function index()
    {
        return view('churchadmin.offerings.index');
    }

    // Additional methods (create, store, show, edit, update, destroy) can be added here as needed.
   
    public function create()
    {
        return view('churchadmin.offerings.create');

    }
    
}