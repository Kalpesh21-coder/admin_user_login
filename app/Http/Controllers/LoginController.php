<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }

    public function authentication(Request $request){
        $valid = Validator::make($request->all(),[
            'email' => 'required | email',
            'password' => 'required | numeric | min:3 ',
        ]);

        if($valid->passes()){

            if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){

                return redirect()->route('user.dash');

            }else{

                return redirect()->route('user.login')->with('error', 'something wrong please fill again...');

            }




        }else{
            return redirect()->route('user.login')->withInput()->withErrors($valid);
        }
    }


    public function register(){
        return view('register');
    }

    public function checkRegister(Request $request){

        $valid = Validator::make($request->all(),[
            'name' => 'required ',
            'email' => 'required | email',
            'password' => 'required | confirmed | numeric | min:3 ',
        ]);

        if($valid->passes()){

            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = "customer";
            $user->save();

            return redirect()->route('user.login')->with('success', 'Register successfully...');



        }else{
            return redirect()->route('user.register')->withInput()->withErrors($valid);
        }

    }

    public  function logout(){
        Auth::logout();
        return redirect()->route('user.login');

    }

}
