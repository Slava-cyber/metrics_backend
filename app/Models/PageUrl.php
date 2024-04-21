<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $name
 * @property int $domain_id
 * @property boolean $pause
 * @property Domain $domain
 */
class PageUrl extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'domain_id',
        'pause'
    ];

    /**
     * @return BelongsTo
     */
    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class, 'domain_id', 'id');
    }
}
