<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    function register(Request $request){
        $validator =  Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        else {
            $user = User::create($request->except('password') + [
                'password' => bcrypt($request->password)
            ]);
            $success['token'] = $user->createToken($user->id)->plainTextToken;
            $success['user'] = $user;
            return response()->json($success, 201);
        }
    }
    function login(Request $request){
        $validator =  Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }else{
            if (Auth::attempt($request->all())) {
                $success['token'] = Auth::user()->createToken(Auth::user()->id)->plainTextToken;
                $success['user'] = Auth::user();
                return response()->json($success, 201);
            } else {
                return response()->json('Email or password is wrong');
            }
        }
    }
}
