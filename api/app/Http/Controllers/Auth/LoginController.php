<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\APIHelpers;
use App\Http\Requests\User\SignInValidation;
use App\Http\Resources\User\UserResource;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * @param SignInValidation $request
     * @return \Illuminate\Http\JsonResponse|void
     * @throws ValidationException
     */
    public function login(SignInValidation $request)
    {
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


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

        return \response()->json(
            APIHelpers::createAPIResponse(
                false,
                Response::HTTP_OK,
                "Login Success",
                [
                    'token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => $expiration,
                    'user' => new UserResource($user)
                ]
            ),
            Response::HTTP_OK
        );
    }


    /**
     * @param Request $request
     * @throws ValidationException
     */
    public function sendFailedLoginResponse(Request $request)
    {
        $code = Response::HTTP_UNPROCESSABLE_ENTITY;

        $message = "Invalid Credentials!";

        $response = APIHelpers::createAPIResponse(true, $code, $message);

        throw new HttpResponseException(\response($response, Response::HTTP_OK));
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        $this->guard()->logout();
        return response()->json(APIHelpers::createAPIResponse(
            false,
            Response::HTTP_OK,
            "Logged out successfully!"
        ), Response::HTTP_OK);
    }

}
