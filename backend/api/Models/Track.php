<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InvalidArgumentException;

/**
 * @property float $length_km
 */
class Track extends Model
{
    // Define the table name explicitly if it's not the plural of the model name
    public $timestamps = false;

    // Primary key is 'id', and Eloquent will automatically handle it
    protected $table = 'tracks';

    // Disable timestamps since the table doesn't have created_at/updated_at columns
    protected $primaryKey = 'id';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'name',
        'length_km',
        'continent',
        'country_id',
        'description',
    ];

    /**
     * @var array<string, string>
     * todo cast all the fields to their necessary type
     */
    protected $casts = [
        'length_km' => 'float',
    ];

    /**
     * Override the save method to enforce non-negative length_km
     */
    protected static function booted(): void
    {
        static::saving(function (self $track) {
            if ($track->length_km < 0) {
                throw new InvalidArgumentException(
                    'The length of the track must be a non-negative number.',
                );
            }
        });
    }

    /**
     * @return BelongsTo<Country, $this>
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
