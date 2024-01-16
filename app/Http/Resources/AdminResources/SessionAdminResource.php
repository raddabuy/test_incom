<?php

namespace App\Http\Resources\AdminResources;

use Illuminate\Http\Resources\Json\JsonResource;

class SessionAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'film_id'           => $this->film_id,
            'session_datetime'  => $this->session_datetime,
            'cost'  => $this->cost,
            "created_at"   => $this->created_at,
            "updated_at"   => $this->updated_at,

            // RelationShips
            'film'       => new FilmAdminResource($this->whenLoaded('film')),
        ];
    }
}
