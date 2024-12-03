<?php

declare(strict_types=1);

namespace App\Authentication;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;

class BasicAuthenticator
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validate(string $username, string $password): bool
    {
        /** @var User|null $user */
        $user = $this->userRepository->findBy('username', $username);
        if ($user && password_verify($password, $user->password)) {
            return true;
        }
        return false;
    }
}
