<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Session;
use App\User;

class UserController extends Controller
{
    /**
     * User Registration
     */
    public function registerUser(Request $request){
        try{
            // set validation rules
            $rules = [
                'name'=>'required',
                'email'=>'required',
                'phone'=>'required',
                'password'=>'required',
                'confirm_password'=>'required|same:password'
            ];
            $validator = Validator::make($request->all(),rules);
            if($validator->fails()){
                return redirect()->back()->withInput()->withErrors($validator);
            }

            # collect data
            $name = $request->name;
            $email = $request->email;
            $phone = $request->phone;
            $password = Hash::make($request->password);

            // validate email
            $validateEmail = User::where('email',$email)->first();
            if($validateEmail){
                $error = Session::flash('error', 'Email already exists.');
                return redirect()->back()->with($error);
            }

            // validate phone
            $validatePhone = User::where('phone',$phone)->first();
            if($validatePhone){
                $error = Session::flash('error', 'Phone number already exists.');
                return redirect()->back()->with($error);
            }

            // register user
            $register = User::create([
                'name'=> $name,
                'email'=> $email,
                'phone'=> $phone,
                'password'=> $password
                
            ]);
            if($register){
                $success = Session::flash('success', 'Registration successful');
                return redirect()->to('/login')->with($success);
            }
            $error = Session::flash('error', 'Registration Failed');
                return redirect()->to('/register')->with($error);

        }catch(\Exception $ex){

        }

    }
}
