<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property boolean $pause
 * @property PageUrl[] $pages
 */
class Domain extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'pause'
    ];

    /**
     * @return HasMany
     */
    public function pages(): HasMany
    {
        return $this->hasMany(PageUrl::class, 'domain_id', 'id');
    }
}
