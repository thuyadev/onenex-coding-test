<?php

namespace App\Http\Requests\Api;

use App\Models\Movie;
use App\Rules\CheckImage;
use Illuminate\Foundation\Http\FormRequest;

class StoreMovieFormRequest extends FormRequest
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
            'cover_image' => ['required', new CheckImage],
            'author' => 'required|string',
            'imdb_rating' => 'required|string',
            'genres' => 'required|array',
            'genres.*' => 'required|int|exists:genres,id',
            'tags' => 'required|array',
            'tags.*' => 'required|int|exists:tags,id'
        ];
    }

    /**
     * @param array $data
     * @return Movie
     */
    public function toMovie(array $data): Movie
    {
        $movie = new Movie($data);
        $movie['user_id'] = auth()->user()->id;

        return $movie;
    }
}
