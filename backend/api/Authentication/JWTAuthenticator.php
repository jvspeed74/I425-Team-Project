<?php

declare(strict_types=1);

namespace App\Authentication;

use App\Repositories\TokenRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuthenticator
{
    private const SECRET_KEY = 'secret';
    private TokenRepository $tokenRepository;

    public function __construct(TokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * @param string $token
     * @return array<mixed>
     */
    public function validate(string $token): array
    {
        try {
            $decoded = JWT::decode($token, new Key(self::SECRET_KEY, 'HS256'));
            return (array) $decoded;
        } catch (\Throwable) {
            return [];
        }
    }

    public function generate(): string
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // jwt valid for 1 hour
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
        ];

        $jwtToken = JWT::encode($payload, self::SECRET_KEY, 'HS256');
        $this->tokenRepository->create([
            'token' => $jwtToken,
            'token_type' => 'jwt',
            'expires_at' => date('Y-m-d H:i:s', $expirationTime),
        ]);

        return $jwtToken;
    }
}
