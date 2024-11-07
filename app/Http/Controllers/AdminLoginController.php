<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function authentication(Request $request)
    {

        $valid = Validator::make($request->all(), [
            'email' => 'required | email',
            'password' => 'required | numeric | min:3 ',
        ]);

        if ($valid->passes()) {

            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {

                if(Auth::guard('admin')->user()->role != "admin"){

                    Auth::guard('admin')->logout();

                    return redirect()->route('admin.login')->with('error', 'you dont have authorization for login...');

                }

                return redirect()->route('admin.dash');
            } else {

                return redirect()->route('admin.login')->with('error', 'something wrong please fill again...');
            }
        } else {
            return redirect()->route('admin.login')->withInput()->withErrors($valid);
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }
}
