<?php

namespace App\Repositories\Movie;

use App\Models\Movie;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MovieRepository implements MovieRepositoryInterface
{
    /**
     * @param Movie $movie
     * @return Movie
     */
    public function create(Movie $movie): Movie
    {
        $movie->save();

        return $movie;
    }

    /**
     * @param Movie $movie
     * @return Movie
     */
    public function update(Movie $movie): Movie
    {
        $movie->save();

        return $movie;
    }

    /**
     * @param Movie $movie
     * @param array $genres
     * @return string
     */
    public function createMovieGenres(Movie $movie, array $genres): string
    {
        $movie->genres()->attach($genres);

        return 'success';
    }

    /**
     * @param Movie $movie
     * @param array $genres
     * @return string
     */
    public function syncMovieGenres(Movie $movie, array $genres): string
    {
        $movie->genres()->sync($genres);

        return 'success';
    }

    /**
     * @param Movie $movie
     * @param array $genres
     * @return string
     */
    public function createMovieTags(Movie $movie, array $tags): string
    {
        $movie->tags()->attach($tags);

        return 'success';
    }

    /**
     * @param Movie $movie
     * @param array $genres
     * @return string
     */
    public function syncMovieTags(Movie $movie, array $tags): string
    {
        $movie->tags()->sync($tags);

        return 'success';
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getMovies(): LengthAwarePaginator
    {
        return Movie::latest()->paginate(10);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getMoviesByUser(): LengthAwarePaginator
    {
        return auth()->user()->movies()->latest()->paginate(10);
    }

    /**
     * @param Movie $movie
     * @return string
     */
    public function delete(Movie $movie): string
    {
        $movie->genres()->detach();
        $movie->tags()->detach();
        $movie->delete();

        return 'success';
    }

    /**
     * @return Collection
     */
    public function relatedMovies(Movie $movie): Collection
    {
        return Movie::where('imdb_rating', $movie->imdb_rating)
            ->where('id', '!=', $movie->id)
            ->where('author', $movie->author)
            ->where(function ($q) use ($movie) {
                foreach ($movie->genres as $genre)
                {
                    $q->whereHas('genres', function ($query) use ($genre) {
                        return $query->where('genre_id', $genre->id);
                    });
                }
            })
            ->where(function ($q) use ($movie) {
                foreach ($movie->tags as $tag)
                {
                    $q->whereHas('tags', function ($query) use ($tag) {
                        return $query->where('tag_id', $tag->id);
                    });
                }
            })
            ->take(7)->get();
    }
}
