<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\APIHelpers;
use App\Http\Requests\User\SignUpValidation;
use App\Http\Resources\User\UserResource;
use App\Repositories\Contracts\User\IUser;
use App\User;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    protected $users;

    /**
     * @param IUser $users
     */
    public function __construct(IUser $users)
    {
        $this->users = $users;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = $this->users->all();

        return response()->json(APIHelpers::createAPIResponse(
            false,
            Response::HTTP_FOUND,
            $users->count() . " users found!",
            UserResource::collection($users)
        ), Response::HTTP_OK);
    }

    /**
     * @param SignUpValidation $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SignUpValidation $request)
    {
        $user = $this->users->create($request->all());

        return response()->json(APIHelpers::createAPIResponse(
            false,
            Response::HTTP_CREATED,
            "User created successfully",
            new UserResource($user)
        ), Response::HTTP_OK);
    }

    /**
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * @param SignUpValidation $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SignUpValidation $request, User $user)
    {
        $user = $this->users->update($user->id, $request->all());

        return response()->json(APIHelpers::createAPIResponse(
            false,
            Response::HTTP_CREATED,
            'User updated successfully',
            new UserResource($user)
        ), Response::HTTP_OK);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $this->users->delete($user->id);

        return response()->json(APIHelpers::createAPIResponse(
            false,
            Response::HTTP_OK,
            'User deleted successfully'
        ), Response::HTTP_OK);
    }
}
