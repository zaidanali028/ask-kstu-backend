<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){

        return view('admin.dashboard');

    }

    public function login(){
        Session::put('page','LOGIN');
        return view('admin.login');
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    public function categories(){
        Session::put('page','categories');
        return view('admin.categories');




    }
}