<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    function getlogin(){
    	return view('admin.adminLogin');
    }

    function postlogin(Request $request){
    	$request->validate([
    		'email' => 'required|email',
    		'password' => 'required|min:6',
    	]);

    	if(Auth::attempt([ 'email' => $request->email, 'password' => $request->password])){
    		
    		return redirect()->route('users.index');
    	}else{
    		return redirect('admin/login')->withInput()->with('danger', 'Incorrect email or password');
    	}
    }

    function logout(){
    	return redirect('admin/login');
    }
}
