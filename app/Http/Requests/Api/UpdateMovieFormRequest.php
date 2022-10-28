<?php

namespace App\Http\Requests\Api;

use App\Models\Movie;
use App\Rules\CheckImage;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'summary'  => 'required|string',
            'cover_image' => ['nullable', new CheckImage],
            'author' => 'required|string',
            'imdb_rating' => 'required|string',
            'genres' => 'required|array',
            'genres.*' => 'required|int|exists:genres,id',
            'tags' => 'required|array',
            'tags.*' => 'required|int|exists:tags,id'
        ];
    }

    /**
     * @param Movie $movie
     * @param array $data
     * @return Movie
     */
    public function toMovie(Movie $movie, array $data): Movie
    {
        $movie['title'] = $data['title'];
        $movie['summary'] = $data['summary'];
        $movie['cover_image'] = isset($data['cover_image']) ? $data['cover_image'] : $movie['cover_image'];
        $movie['author'] = $data['author'];
        $movie['imdb_rating'] = $data['imdb_rating'];
        $movie['user_id'] = auth()->user()->id;

        return $movie;
    }
}
