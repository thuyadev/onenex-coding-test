<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * @param User $user
     * @return User
     */
    public function create(User $user): User;
}
