<?php

namespace App\Http\Resources\AdminResources;

use Illuminate\Http\Resources\Json\JsonResource;

class FilmAdminResource extends JsonResource
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
            'name'         => $this->name,
            'description'  => $this->description,
            'duration'  => $this->duration,
            'age_limit'  => $this->age_limit,
            "created_at"   => $this->created_at,
            "updated_at"   => $this->updated_at,

            // media
            'image'        => $this->when(
                $hFiles = $this->getMedia('film_image')->transform(
                    function ($item, $key) {
                        $item['link'] = $item->getFullUrl();

                        return $item;
                    }
                )->toArray(),
                $hFiles
            ),

            // RelationShips
            'sessions'       => SessionAdminResource::collection($this->whenLoaded('sessions')),
        ];
    }
}
