<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    // Define the table name explicitly if it's not the plural of the model name
    public $timestamps = false;

    // Primary key is 'id', and Eloquent will automatically handle it
    protected $table = 'countries';

    // Disable timestamps since the table doesn't have created_at/updated_at columns
    protected $primaryKey = 'id';

    // Define the fillable fields for mass assignment
    protected $fillable = ['name'];

    /**
     * @var array<string, string>
     * todo cast all the fields to their necessary type
     */
    protected $casts = [];

    /**
     * @return HasMany<Track, $this>
     */
    public function track(): HasMany
    {
        return $this->hasMany(Track::class, 'country_id', 'id');
    }
}
