<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    // Define the table name explicitly if it's not the plural of the model name
    public $timestamps = false;

    // Primary key is 'id', and Eloquent will automatically handle it
    protected $table = 'events';

    // Disable timestamps since the table doesn't have created_at/updated_at columns
    protected $primaryKey = 'id';

    // Define the fillable fields for mass assignment
    protected $fillable = ['title', 'scheduled_date', 'track_id', 'status'];

    /**
     * @var array<string, string>
     * todo cast all the fields to their necessary type
     */
    protected $casts = [
        'scheduled_date' => 'date:Y-m-d',
    ];

    /**
     * @return BelongsTo<Track, $this>
     */
    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class, 'track_id', 'id');
    }
}
