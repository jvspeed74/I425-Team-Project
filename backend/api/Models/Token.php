<?php

declare(strict_types=1);

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string $token_type
 * @property bool $revoked
 * @property datetime $expires_at
 */
class Token extends Model
{
    protected $fillable = [
        'user_id',
        'token',
        'token_type',
        'revoked',
        'expires_at',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
