<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\AbstractRepository;
use App\Models\User;

class UserRepository extends AbstractRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
