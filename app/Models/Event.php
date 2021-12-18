<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'uuid';

    public $repeatOptions = [
        'Week',
        'Two Weeks',
        'Four Weeks'
    ];

    public $eventTypes = [
        'Playlist',
        'Live DJ',
        'Live Relay'
    ];

    public $trackInfoOptions = [
        'Default',
        'Playlist'
    ];

    // automatically convert the
    // days of the week field to an array
    // we'll need to encode it again for the resource thouugh
    protected $casts = [
        'days_of_week' => 'array'
    ];

    public function getDaysOfWeek(): string
    {
        return json_encode($this->days_of_week);
    }

    public function getRepeat(): string
    {
        // mysql stored the enum values as strings
        // so please excuse the intval()
        // fml!
        return $this->repeatOptions[
            intval($this->repeat)
        ];
    }

    public function getEventType(): string
    {
        return $this->eventTypes[
            intval($this->event_type)
        ];
    }

    public function getTrackInfo(): string
    {
        return $this->trackInfoOptions[
            intval($this->track_info)
        ];
    }
}
