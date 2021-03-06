<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
        ]);

        $checkEmail = User::where('email', $request->get('email'))->first();

        if ($checkEmail) {
            return response()->json(['message' => 'User with this email address exist.'], 409);
        }

        $checkUsername = User::where('username', $request->get('username'))->first();

        if ($checkUsername) {
            return response()->json(['message' => 'User with this username exist.'], 409);
        }


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        User::create($input);

        return response()->json(['message' => 'Account created, you can login now.']);
    }
}
