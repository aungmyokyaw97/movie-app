<?php

namespace App\Http\Resources\API\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieListResource extends JsonResource
{
    public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            "director" => $this->director,
            "tags" => $this->tags,
            "rating" => $this->rating,            
            "user_name" => $this->user->name,
            "genres" => GenreResource::collection($this->whenLoaded('genres')),
        ];

    }

}
