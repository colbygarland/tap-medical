<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Patient
 * @package App
 * @mixin \Eloquent
 */
class Patient extends Model
{
    /**
     * The maximum age of a patient to store appointments for.
     */
    const MAX_AGE = 18;

    protected $fillable = [
        'id', 'name', 'date_of_birth', 'sex', 'created_at', 'updated_at',
    ];
}
