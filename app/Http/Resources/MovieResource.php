<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'author' => $this->author,
            'imdb_rating' => $this->imdb_rating,
            'cover_image' => $this->cover_image,
            'genres' => GenreResource::collection($this->genres),
            'tags' => TagResource::collection($this->tags),
            'user' => new UserResource($this->user)
        ];
    }
}
