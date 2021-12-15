<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DownloadedEpisodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // load some relations when they are eager loaded
        // TODO: consider using resources for episodes, events and podcasts
        // if the relations aren't eager loaded, fall back to the Id
        return [
            'id'                 => $this->id,
            'episode'            => $this->whenLoaded(
                'episode',
                $this->episode,
                $this->episode_id
            ),
            'event'              => $this->whenLoaded(
                'event',
                $this->event,
                $this->event_id
            ),
            'podcast'            => $this->whenLoaded(
                'podcast',
                $this->podcast,
                $this->podcast_id
            ),
            'ocurred_at'         => $this->created_at
        ];
    }
}
