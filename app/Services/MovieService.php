<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Http\Requests\Api\StoreMovieFormRequest;
use App\Http\Requests\Api\UpdateMovieFormRequest;
use App\Models\Movie;
use App\Repositories\Movie\MovieRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class MovieService
{
    /**
     * @param MovieRepositoryInterface $movieRepository
     * @param ImageUploadService $imageUploadService
     */
    public function __construct(
        private MovieRepositoryInterface $movieRepository,
        private ImageUploadService $imageUploadService,
    )
    {}

    /**
     * @return LengthAwarePaginator
     */
    public function getMovies(): LengthAwarePaginator
    {
        $movies = $this->movieRepository->getMovies();

        return $movies;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getMoviesByUser(): LengthAwarePaginator
    {
        $movies = $this->movieRepository->getMoviesByUser();

        return $movies;
    }

    public function getMovieDetail(Movie $movie): array
    {
        $related_movies = $this->movieRepository->relatedMovies($movie);

        return [
            'movie' => $movie,
            'related_movies' => $related_movies
        ];
    }

    /**
     * @param StoreMovieFormRequest $request
     * @return Movie
     * @throws CustomException
     */
    public function create(StoreMovieFormRequest $request): Movie
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();

            $to_movie = $request->toMovie($data);

            $cover_image = $this->imageUploadService->upload($data['cover_image'], $to_movie);

            $to_movie['cover_image'] = $cover_image;

            $movie = $this->movieRepository->create($to_movie);

            $this->movieRepository->createMovieGenres($movie, $data['genres']);

            $this->movieRepository->createMovieTags($movie, $data['tags']);

            DB::commit();
        }
        catch (\Exception $exception)
        {
            DB::rollBack();

            throw new CustomException($exception->getMessage(), $exception->getCode());
        }

        return $movie;
    }

    /**
     * @param UpdateMovieFormRequest $request
     * @param Movie $movie
     * @return Movie
     * @throws CustomException
     */
    public function update(UpdateMovieFormRequest $request, Movie $movie): Movie
    {
        try {
            DB::beginTransaction();

            if ($movie['user_id'] !== auth()->user()->id)
            {
                throw new CustomException('Unauthorized!', 404);
            }

            $data = $request->validated();

            if (isset($data['cover_image']) && $data['cover_image'] !== null)
            {
                $this->imageUploadService->delete($movie['cover_image']);
                $cover_image = $this->imageUploadService->upload($data['cover_image'], $movie);
                $data['cover_image'] = $cover_image;
            }

            $to_movie = $request->toMovie($movie, $data);

            $movie = $this->movieRepository->update($to_movie);

            $this->movieRepository->syncMovieGenres($movie, $data['genres']);

            $this->movieRepository->syncMovieTags($movie, $data['tags']);

            DB::commit();
        }
        catch (\Exception $exception)
        {
            DB::rollBack();

            throw new CustomException($exception->getMessage(), $exception->getCode());
        }

        return $movie;
    }

    /**
     * @param Movie $movie
     * @return string
     */
    public function delete(Movie $movie): string
    {
        if ($movie['user_id'] !== auth()->user()->id)
        {
            throw new CustomException('Unauthorized!', 404);
        }

        $this->imageUploadService->delete($movie['cover_image']);

        $this->movieRepository->delete($movie);

        return 'success';
    }
}
