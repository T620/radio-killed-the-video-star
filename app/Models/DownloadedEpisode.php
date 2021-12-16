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
        'occurred_at',
        'event_id'
    ];

    // cast the occurred_at date to ISO 8601.
    protected $casts = [
        'occurred_at' => 'datetime:c'
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
}
