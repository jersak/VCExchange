<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\User;

class UserController extends Controller
{
    public function getUserbyId($id)
    {
        $user = User::where('id', $id)->first();

        if (empty($user)) {
            return response()->json('User not found.', 404);
        }

        return $user;
    }
}
