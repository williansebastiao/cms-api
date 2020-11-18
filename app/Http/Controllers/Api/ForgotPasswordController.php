<?php

namespace App\Http\Controllers\Api;

use App\Constants\ApiMessages;
use App\Constants\ApiStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    public function broker() {
        return Password::broker();
    }

    protected function sendResetLinkEmail(Request $request) {

        try {

            $this->validate($request, ['email' => 'required|email']);

            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );

            switch ($response) {
                case Password::RESET_LINK_SENT:
                    return response()->json([
                        'message' => ApiMessages::reset
                    ], ApiStatus::success);

                case Password::INVALID_USER:
                default:
                    return response()->json([
                        'message' => ApiMessages::resetError
                    ], ApiStatus::unprocessableEntity);
            }

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], ApiStatus::unprocessableEntity);
        }
    }

}
