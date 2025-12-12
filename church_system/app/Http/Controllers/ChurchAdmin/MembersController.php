<?php
namespace App\Http\Controllers\ChurchAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
 
class MembersController extends Controller
{
    /**
     * Display a listing of the members.
     */
    public function index()
    {
        return view('churchadmin.members.index');
    }

    // Additional methods (create, store, show, edit, update, destroy) can be added here as needed.
    public function create()
    {
        return view('churchadmin.members.create');

    }

    // edit method
    public function edit(Member $member) // Type-hinted for Route Model Binding
{
    // Pass the $member model to the view
    return view('churchadmin.members.edit', compact('member'));
}

    
}