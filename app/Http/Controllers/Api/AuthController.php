<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
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
}
