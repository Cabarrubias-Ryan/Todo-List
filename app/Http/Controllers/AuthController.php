<?php

namespace App\Http\Controllers;


use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use Carbon\Carbon;


class AuthController extends Controller
{
    public function login(){
        return view('auth.login');
    }
    public function registerAccount(){
        return view('auth.register');
    }

    public function registerSave(Request $request) {

        Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'username' => ['required','unique:User'],
            'password' => [
                'required',
                'min:5', // Minimum 5 characters
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[a-z]/', // At least one lowercase letter
                'regex:/[0-9]/', // At least one number
                'regex:/[@$!%*?&.]/', // At least one special character
                'confirmed'
            ]
        ])->validate();

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'created_at' =>  Carbon::now(),
            'role' => 'user',
            'updated_at' =>  null,
            'deleted_at' =>  null
        ]);

        return redirect()->route('login'); // change it later
    }

    public function loginAccount(Request $request) {
        
        Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ] )->validate();

        if(!Auth::attempt($request->only('username','password'))) {
            throw ValidationException::withMessages([
                'username' => trans('auth.failed')
            ]);
        }

        $request->session()->regenerate();

        if(auth()->user()->role == 'admin') {
            return redirect()->route('admin.dashboard')->with('success',"You have Login successfully");
        }
        return redirect()->route('user.dashboard')->with('success',"You have Login successfully");
    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
 
        $request->session()->invalidate();
 
        return redirect()->route('welcome');
    }

}
