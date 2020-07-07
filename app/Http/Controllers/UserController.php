<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    protected function updateUserValidator($id, array $data)
    {
        return Validator::make($data, [
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'username' => ['sometimes', 'string'],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
            'role' => ['sometimes', 'in:admin,user'],
        ]);
    }

    public function getMe()
    {
        return Auth::user();
    }

    public function updateMe(Request $request)
    {
        $user = Auth::user();

        $validator = $this->updateUserValidator($user->id, $request->all());

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $password = null;

        // If the user is updating password, we need to check current password match
        if ($request['current_password'] && $request['new_password'] && $request['new_password_confirmation']) {
            if (!Hash::check($request['current_password'], $user->password)) {
                return response(['errors' => ['Current password does not match.']], 422);
            }

            if ($request['new_password'] != $request['new_password_confirmation']) {
                return response(['errors' => ['Password confirmation does not match.']], 422);
            }

            $password = Hash::make($request['new_password']);
        }

        if ($request->email) {
            $user->email = $request->email;
        }

        if ($request->username) {
            $user->username = $request->username;
        }

        if ($password) {
            $user->password = $password;
        }

        $user->save();

        return $user;
    }
}
