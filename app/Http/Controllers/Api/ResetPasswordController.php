<?php

namespace App\Http\Controllers\Api;

use App\Constants\ApiMessages;
use App\Constants\ApiStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller {

    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard() {
        return Auth::guard('administrator');
    }

    /**
     * @return mixed
     */
    public function broker() {
        return Password::broker('administrators');
    }

    public function reset(Request $request) {

        try {

            $credentials = $this->validate($request, [
                'email' => 'required|email',
                'token' => 'required|string',
                'password' => 'required|string'
            ]);

            $response = $this->broker()->reset($credentials, function ($user, $password) {
                $user->password = $password;
                $user->save();
            });

            switch ($response) {
                case Password::PASSWORD_RESET:
                    return response()->json(['message' => ApiMessages::passwordSuccess], ApiStatus::success);
                case Password::INVALID_TOKEN:
                    return response()->json(['message' => ApiMessages::passwordToken], ApiStatus::unprocessableEntity);
                case Password::INVALID_USER:
                    return response()->json(['message' => ApiMessages::passwordUserInvalid], ApiStatus::unprocessableEntity);
                default:
                    return response()->json(['message' => ApiMessages::passwordError], ApiStatus::unprocessableEntity);
            }

        } catch (\Exception $e) {
            return $e->getFile();
        }


    }
}
