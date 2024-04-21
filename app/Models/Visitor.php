<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $ip
 */
class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip'
    ];
}
