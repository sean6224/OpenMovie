<?php
declare(strict_types=1);

namespace App\Movies\Application\UseCase\Query\GetMovie;

use App\Common\Application\Query\QueryHandler;
use App\Common\Domain\ValueObject\Id;

use App\Movies\Domain\Repository\MovieRepository;
use App\Movies\Application\DTO\MovieDTO;
use App\Movies\Domain\Exception\MovieNotFound;

/**
 * Query handler for retrieving details of a single movie.
 *
 * This handler is responsible for processing the `GetMovieQuery` and fetching the details of a movie from the repository based on its unique identifier (ID).
 */
final readonly class GetMovieQueryHandler implements QueryHandler
{
    /**
     * Constructs a new GetMovieQueryHandler instance.
     *
     * @param MovieRepository $movieRepository The repository for accessing movie data.
     */
    public function __construct(
        private MovieRepository $movieRepository
    ){
    }

    /**
     * Handles the GetMovieQuery to retrieve details of a single movie.
     *
     * @param GetMovieQuery $query The query object containing the movie ID.
     * @return MovieDTO The DTO representing the movie details.
     * @throws MovieNotFound If the requested movie is not found.
     */
    public function __invoke(GetMovieQuery $query): MovieDTO
    {
        $movie = $this->movieRepository->get(Id::fromString($query->movieId));
        return MovieDTO::fromEntity($movie);
    }
}
