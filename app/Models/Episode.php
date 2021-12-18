<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Podcast;

class Episode extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'uuid';

    public function podcast(): BelongsTo
    {
        return $this->belongsTo(Podcast::class);
    }

    public function downloadLink(): string
    {
        // TODO: convert to a cast if poss
        return urldecode($this->file_url);
    }

    public function imageLink(): string
    {
        // TODO: convert to a cast if poss
        return urldecode($this->image_url);
    }
}
