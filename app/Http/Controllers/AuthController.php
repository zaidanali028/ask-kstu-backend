<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    // kvngthr!v3 commited->

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','home']]);
    }

    public  function get_auth_user(Request $request ){
        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,

        ], 200);

    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ], 200);

    }

    public function register(Request $request)
    {
    Validator::make($request->all(),[
        'email' => 'required|string|email|max:255|unique:users',
        'name' => 'required|regex:/^[\pL\s\-]+$/u|string|max:255',
        'password' => 'required|confirmed|min:10|alpha_num|max:30',
        'gender' => 'required',
        'admin_type' => 'required',
    ])->validate();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,

            'admin_type' => $request->admin_type,

        ]);




        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ], 201);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ],200);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ],
        ]);
    }

}