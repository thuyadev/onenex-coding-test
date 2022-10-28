<?php

namespace App\Repositories\Movie;

use App\Models\Movie;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface MovieRepositoryInterface
{
    /**
     * @param Movie $movie
     * @return Movie
     */
    public function create(Movie $movie): Movie;

    /**
     * @param Movie $movie
     * @return Movie
     */
    public function update(Movie $movie): Movie;

    /**
     * @param Movie $movie
     * @param array $genres
     * @return string
     */
    public function createMovieGenres(Movie $movie, array $genres): string;

    /**
     * @param Movie $movie
     * @param array $genres
     * @return string
     */
    public function syncMovieGenres(Movie $movie, array $genres): string;

    /**
     * @param Movie $movie
     * @param array $genres
     * @return string
     */
    public function createMovieTags(Movie $movie, array $genres): string;

    /**
     * @param Movie $movie
     * @param array $genres
     * @return string
     */
    public function syncMovieTags(Movie $movie, array $genres): string;

    /**
     * @return LengthAwarePaginator
     */
    public function getMovies(): LengthAwarePaginator;

    /**
     * @return LengthAwarePaginator
     */
    public function getMoviesByUser(): LengthAwarePaginator;

    /**
     * @return Collection
     */
    public function relatedMovies(Movie $movie): Collection;

    /**
     * @param Movie $movie
     * @return string
     */
    public function delete(Movie $movie): string;
}
