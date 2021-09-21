<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * @param Request $request
     * @return bool
     */
    public function attemptLogin(Request $request): bool
    {
        // Attempt to issue a token to the user based on the login credentials
        $token = $this->guard()->claims(['email' => $request->email])->attempt($this->credentials($request));

        if (!$token) {
            return false;
        }

        // Set the user's token
        $this->guard()->setToken($token);

        return true;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendLoginResponse(Request $request): \Illuminate\Http\JsonResponse
    {
        // Clear login attempts
        $this->clearLoginAttempts($request);

        // Get the token from the authentication guard (JWT)
        $token = (string)$this->guard()->getToken();

        // Extract the expiry date of the token
        $expiration = $this->guard()->getPayload()->get('exp');

        $user = $this->guard()->user();

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration,
            'user' => new UserResource($user)
        ]);
    }


    /**
     * @param Request $request
     * @throws ValidationException
     */
    public function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            "email" => "Invalid Credentials"
        ]);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        $this->guard()->logout();
        return response()->json(['message' => 'Logged out successfully!']);
    }

}
