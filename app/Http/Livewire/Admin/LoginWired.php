<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginWired extends Component
{
    public $inputs=[];

    protected $rules = [
        'email' => 'required|email|max:255',
        'password' => 'required|min:8',
    ];
   public  $customMsgs = [
        'email.required' => 'Email is required',
        'email.email' => 'Valid Email is required',
        'password.required' => 'Password is required',
        'password.min' => 'Password can not be less than 8 characters',
    ];
public function process_login(){
    $validated_data=Validator::make($this->inputs,$this->rules,$this->customMsgs)->validate();


    if (Auth::guard('admin')->attempt(['email' => $this->inputs['email'], 'password' => $this->inputs['password']])) {
        $this->dispatchBrowserEvent('show-success-toast',["success_msg"=>'LOGIN SUCCESS!']);
        return redirect('/admin/dashboard');
    } else {
        return back()->with('error_msg', "Invalid Email/Password");
    }
}
    public function render()
    {
        return view('livewire.admin.login-wired');
    }
}