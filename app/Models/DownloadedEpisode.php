<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    // cast the created_at date to ISO 8601.
    protected $casts = [
        'created_at' => 'datetime:c'
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
