<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    // Define the table name explicitly if it's not the plural of the model name
    protected $table = 'cars';

    // Primary key is 'id', and Eloquent will automatically handle it
    protected $primaryKey = 'id';

    // Disable timestamps since the table doesn't have created_at/updated_at columns
    public $timestamps = false;

    // Define the fillable fields for mass assignment
    protected $fillable = ['team_id', 'model', 'year'];


    /**
     * @return BelongsTo<Team, $this>
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }
}
