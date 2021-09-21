<?php

namespace App\Repositories\Eloquent\User;

use App\Repositories\Contracts\User\IUser;
use App\Repositories\Eloquent\BaseRepository;
use App\User;

class UserRepository extends BaseRepository implements IUser
{
    public function model(): string
    {
        return User::class;
    }
}
