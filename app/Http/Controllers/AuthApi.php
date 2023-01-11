<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthApi extends Controller
{
    public function login(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email' => "required|email",
            'password' => "required"
        ]);

        if ($v->fails()) {
            return $this->error($v->errors());
        }

        $user = User::where('email', $request->email)->first();

        //check email
        if (!$user) {
            $v->errors()->add('email', 'Email Not Found!');
            return $this->error($v->errors());
        }

        //check password
        if (!Hash::check($request->password, $user->password)) {
            $v->errors()->add('password', 'Wrong Password');
            return $this->error($v->errors());
        }
        //response user with token

        $token = $user->createToken('api')->accessToken;
        return $this->success(['token' => $token, 'user' => $user]);
    }

    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => "required",
            'email' => "required|email",
            'password' => "required"
        ]);

        if ($v->fails()) {
            return $this->error($v->errors());
        }

        //check email already exist
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $v->errors()->add('email', 'Email Already Exist');
            return $this->error($v->errors());
        }

        //store to database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //generate token
        $token = $user->createToken('api')->accessToken;
        return $this->success(['token' => $token, 'user' => $user]);
    }

    public function logout()
    {

        if (Auth::guard('api')->check()) {
            User::find(auth()->guard('api')->user()->id)->tokens()->delete();
            return $this->success('logout');
        }
        return $this->error('error');
    }
}
