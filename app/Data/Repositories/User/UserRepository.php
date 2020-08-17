<?php

namespace App\Data\Repositories\User;

/**
 * Interface UserRepository
 * @package App\Data\Repositories\User
 */
interface UserRepository
{
    /**
     * @return mixed
     */
    public function createUser($user);
}
