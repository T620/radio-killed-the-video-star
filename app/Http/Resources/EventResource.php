<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'date_time_start' => $this->date_time_start,
            'date_time_end'   => $this->date_time_end,
            'days_of_week'    => $this->getDaysOfWeek(),
            'playlist_id'     => $this->playlist_id,
            'artwork_url'     => $this->artwork_url,
            'repeat'          => $this->getRepeat(),
            'event_end_date'  => $this->event_end_date,
            'event_type'      => $this->getEventType(),
            'overrun'         => $this->overrun,
            'track_info'      => $this->getTrackInfo(),
        ];
    }
}
