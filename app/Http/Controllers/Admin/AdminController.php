<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page','dashboard');


        return view('admin.dashboard');

    }

    public function login(){
        Session::put('page','login');
        return view('admin.login');
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    public function categories(){
        Session::put('page','categories');
        return view('admin.announcements.categories');
    }

    public function anouncements(){
        Session::put('page','anouncements');
        return view('admin.announcements.anouncements');

    }
    public function announcement_details(){
        Session::put('page','announcement details');
        return view('admin.announcements.announcement_details');

    }
}