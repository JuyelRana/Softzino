<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\APIHelpers;
use App\Http\Requests\User\SignUpValidation;
use App\Http\Resources\User\UserResource;
use App\Repositories\Contracts\User\IUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;


class RegisterController extends Controller
{
    use RegistersUsers;

    protected $users;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(IUser $users)
    {
        $this->users = $users;
    }

    /**
     * @param SignUpValidation $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(SignUpValidation $request)
    {
        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return $this->users->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'birthdate' => $data['birthdate']
        ]);
    }


    /**
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function registered(Request $request, $user)
    {
        return response()->json(APIHelpers::createAPIResponse(
            false,
            Response::HTTP_OK,
            "Registration successfull",
            new UserResource($user)
        ), Response::HTTP_OK);
    }
}
