<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        return view('user.index');
    }
    public function update(int $id,Request $request){

    }
}
