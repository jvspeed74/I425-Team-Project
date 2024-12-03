<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InvalidArgumentException;

/**
 * @property float $career_points
 */
class Driver extends Model
{
    // Define the table name explicitly if it's not the plural of the model name
    public $timestamps = false;

    // Primary key is 'id', and Eloquent will automatically handle it
    protected $table = 'drivers';

    // Disable timestamps since the table doesn't have created_at/updated_at columns
    protected $primaryKey = 'id';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'first_name',
        'last_name',
        'team_id',
        'nationality_id',
        'birthday',
        'driver_number',
        'career_points',
        'career_wins',
        'career_podiums',
        'championships',
    ];

    /**
     * @var array<string, string>
     * todo cast all the fields to their necessary type
     */
    protected $casts = [
        'career_points' => 'float',
    ];

    /**
     * Override the save method to enforce non-negative length_km
     */
    protected static function booted(): void
    {
        static::saving(function (self $driver) {
            if ($driver->career_points < 0) {
                throw new InvalidArgumentException(
                    'Career points must be a non-negative number.',
                );
            }
        });
    }

    /**
     * @return BelongsTo<Team, $this>
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * @return BelongsTo<Nationality, $this>
     */
    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Nationality::class);
    }
}
