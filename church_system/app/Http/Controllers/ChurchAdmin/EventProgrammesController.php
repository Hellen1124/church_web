<?php
namespace App\Http\Controllers\ChurchAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
 
class EventProgrammesController extends Controller
{
    /**
     * Display a listing of the members.
     */
    public function index()
    {
        return view('churchadmin.eventprogrammes.index');
    }

   // Additional methods (create, store, show, edit, update, destroy) can be added here as needed.
    public function create()
    {
        return view('churchadmin.eventprogrammes.create');
    }

    // edit method
    public function edit($event)
    {
        return view('churchadmin.eventprogrammes.edit', compact('event'));
    }
}