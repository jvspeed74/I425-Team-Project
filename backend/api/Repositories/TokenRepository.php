<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\AbstractRepository;
use App\Models\Token;

class TokenRepository extends AbstractRepository
{
    public function __construct(Token $model)
    {
        parent::__construct($model);
    }
}
