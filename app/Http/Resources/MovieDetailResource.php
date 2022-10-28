<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $movie = $this['movie'];
        $related_movies = $this['related_movies'];

        return [
            'id' => $movie->id,
            'title' => $movie->title,
            'summary' => $movie->summary,
            'author' => $movie->author,
            'imdb_rating' => $movie->imdb_rating,
            'cover_image' => $movie->cover_image,
            'genres' => GenreResource::collection($movie->genres),
            'tags' => TagResource::collection($movie->tags),
            'user' => new UserResource($movie->user),
            'comments' => CommentResource::collection($movie->comments),
            'pdf' => config('app.url') . '/api/movie/' . $movie->id . '/pdf-download',
            'related_movies' => MovieResource::collection($related_movies)
        ];
    }
}
