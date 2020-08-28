<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Clinic
 * @package App
 * @mixin \Eloquent
 */
class Clinic extends Model
{
    protected $fillable = [
        'id', 'name', 'auth_type', 'created_at', 'updated_at',
    ];
}
