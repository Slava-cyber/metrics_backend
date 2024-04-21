<?php

namespace App\Models;

use App\Enums\ClickDateFieldsEnum\ClickDateFieldsEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $domain_id
 * @property int $page_url_id
 * @property int $visitor_id
 * @property  int $position_x
 * @property int $position_y
 * @property int $screen_size_x
 * @property int $screen_size_y
 * @property  string $datetime
 * @property string $time_zone
 * @property Domain $domain
 * @property PageUrl $pageUrl
 * @property Visitor $visitor
 */
class Click extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'domain_id',
        'page_url_id',
        'visitor_id',
        'datetime',
        'time_zone',
        'position_x',
        'position_y',
        'screen_size_x',
        'screen_size_y'
    ];

    /**
     * @return BelongsTo
     */
    public function visitor(): BelongsTo
    {
        return $this->belongsTo(Visitor::class, 'visitor_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class, 'domain_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function pageUrl(): BelongsTo
    {
        return $this->belongsTo(PageUrl::class, 'page_url_id', 'id');
    }

    /**
     * @param Builder $query
     * @param int|null $visitorId
     * @return void
     */
    public function scopeByOneVisitor(Builder $query, ?int $visitorId): void
    {
        $query->when($visitorId, function (Builder $query) use ($visitorId) {
            $query->where('visitor_id', $visitorId);
        });
    }

    /**
     * @param Builder $query
     * @param $timeStart
     * @param $timeFinish
     * @param ClickDateFieldsEnum $field
     * @return void
     */
    public function scopeBetweenDates(
        Builder             $query,
                            $timeStart,
                            $timeFinish,
        ClickDateFieldsEnum $field = ClickDateFieldsEnum::CREATED_AT,
    ): void
    {
        $fieldName = $field->value;

        $query->when($timeStart, function (Builder $query) use ($timeStart, $fieldName) {
            $query->whereDay($fieldName, '>=', Carbon::parse($timeStart));
        })
            ->when($timeFinish, function (Builder $query) use ($timeFinish, $fieldName) {
                $query->whereDay($fieldName, '<=', Carbon::parse($timeFinish));
            });
    }

}
