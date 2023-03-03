<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function registration(Request $request)
    {
        $result = User::registration($request);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $result
        ], 201);
    }
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $is_check = Hash::check($request->password, $user->password);

        if ($is_check) {
            return response()->json(['auth' => true, 'id' => $user->id], 200);
        } else {
            return response()->json(['auth' => false], 401);
        }
    }
    public function logout()
    {
        return response()->json(['auth' => false], 200);
    }
    public function getUser($user_id)
    {
        $user = User::where('id',$user_id)->with('reservations','likes.area','likes.genre','likes.likes')->first();

        return response()->json([
            'message' => 'User got successfully',
            'data' => $user
        ], 200);
    }
}