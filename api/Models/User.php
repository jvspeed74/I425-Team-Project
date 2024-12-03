<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $username
 * @property string $password
 */
class User extends Model
{
    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * @return HasMany<Token, $this>
     */
    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class);
    }
}
