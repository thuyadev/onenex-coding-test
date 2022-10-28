<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreMovieFormRequest;
use App\Http\Requests\Api\UpdateMovieFormRequest;
use App\Http\Resources\MovieDetailResource;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Services\MovieService;
use App\Traits\ResponserTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class MovieController extends Controller
{
    use  ResponserTrait;
    /**
     * @param MovieService $movieService
     */
    public function __construct(
        private MovieService $movieService,
    )
    {}

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $movies = $this->movieService->getMoviesByUser();

        return $this->responseSuccessWithPaginate('success', MovieResource::collection($movies));
    }

    /**
     * @param StoreMovieFormRequest $request
     * @return JsonResponse
     * @throws \App\Exceptions\CustomException
     */
    public function store(StoreMovieFormRequest $request): JsonResponse
    {
        $movie = $this->movieService->create($request);

        return $this->responseCreated(new MovieResource($movie));
    }

    /**
     * @param Movie $movie
     * @return JsonResponse
     */
    public function show(Movie $movie): JsonResponse
    {
        $movie_detail = $this->movieService->getMovieDetail($movie);

        return $this->responseSuccess('success', new MovieDetailResource($movie_detail));
    }

    /**
     * @param UpdateMovieFormRequest $request
     * @param Movie $movie
     * @return JsonResponse
     * @throws \App\Exceptions\CustomException
     */
    public function update(UpdateMovieFormRequest $request, Movie $movie): JsonResponse
    {
        $movie = $this->movieService->update($request, $movie);

        return $this->responseSuccess('success', new MovieResource($movie));
    }

    /**
     * @param Movie $movie
     * @return JsonResponse
     */
    public function destroy(Movie $movie): JsonResponse
    {
        $this->movieService->delete($movie);

        return $this->responseMsgOnly('successfully deleted!');
    }

    /**
     * @param Movie $movie
     * @return Response
     */
    public function downloadPdf(Movie $movie): Response
    {
        $pdf = Pdf::loadView('pdf.movie', [
            'movie' => $movie
        ]);

        return $pdf->download('movie.pdf');
    }

    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $movies = $this->movieService->getMovies();

        return $this->responseSuccessWithPaginate('success', MovieResource::collection($movies));
    }
}
