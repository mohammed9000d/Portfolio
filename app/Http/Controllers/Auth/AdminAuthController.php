<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    //
    public function __construct()
    {

    }
    public function showLoginView(){
        return view('admin.auth.login');
    }
    public function login(Request $request){
        $request->validate([
            'email'=> 'required|email',
            'password'=> 'required|string'
        ]);
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ];

        if(Auth::guard('admin')->attempt($credentials)){
            $admin = Auth::guard('admin')->user();
            if($admin){
                return redirect()->route('admin.index');
            }else{
                //
            }

        }else{
            return redirect()->back()->withInput();
        }


    }

    public function logout(Request $request){
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->guest(route('admin.login_view'));
    }
}
