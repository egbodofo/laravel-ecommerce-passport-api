<?php

namespace App\Data\Repositories\User;

use App\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class EloquentRepository
 * @package App\Data\Repositories\User
 */
class EloquentRepository implements UserRepository
{
    public function createUser($user)
    {
        $user->save();

        return $user;
    }
}
