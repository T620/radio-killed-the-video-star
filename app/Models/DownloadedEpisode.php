<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class DownloadedEpisode extends Model
{
    use HasFactory;

    // let all the attrs be mass-assignable
    // I know what I'm doing
    protected $fillable = [
        'id',
        'episode_id',
        'podcast_id',
        'event_id'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'ocurred_at'
    ];

    public function podcast(): BelongsTo
    {
        return $this->belongsTo(Podcast::class);
    }

    public function event(): BelongsTo
    {
        // return $this->belongsTo(Event::class);
        return null;
    }

    public function episode(): BelongsTo
    {
        return $this->belongsTo(Episode::class);
    }

     /**
     * Create this dynamic property which is based
     * of the created_at field
     *
     * @return string
     */
    public function getOcurredAtAttribute()
    {
        return Carbon::parse(
            $this->attributes['created_at']
        )->toISOString();
    }
}
