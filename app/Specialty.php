<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Specialty
 * @package App
 * @mixin \Eloquent
 */
class Specialty extends Model
{
    protected $fillable = [
        'id', 'name', 'created_at', 'updated_at',
    ];
}
