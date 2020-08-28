<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Doctor
 * @package App
 * @mixin Eloquent
 */
class Doctor extends Model
{
    protected $fillable = [
        'id', 'name', 'created_at', 'updated_at',
    ];
}
