<?php

declare(strict_types=1);

namespace App\Authentication;

use App\Models\Token;
use App\Repositories\TokenRepository;
use Random\RandomException;

class BearerAuthenticator
{
    private const DATE_FORMAT = 'Y-m-d H:i:s';
    private TokenRepository $tokenRepository;

    public function __construct(TokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function validate(string $token): bool
    {
        /** @var Token|null $model */
        $model = $this->tokenRepository->findBy('token', $token);
        if ($model
            && $model->token_type === 'bearer'
            && $model->expires_at > date(self::DATE_FORMAT)
        ) {
            return true;
        }
        return false;
    }

    /**
     * @throws RandomException
     */
    public function generate(): string
    {
        $token = bin2hex(random_bytes(32));
        $this->tokenRepository->create([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_at' => date(self::DATE_FORMAT, strtotime('+1 hour')),
        ]);
        return $token;
    }
}
