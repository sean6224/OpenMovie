<?php
declare(strict_types=1);
namespace App\Movies\Application\Service;

use App\Movies\Domain\Repository\MovieRepository;
use App\Movies\Domain\Entity\Movie;
use App\Movies\Application\DTO\MovieDTO;
use App\Movies\Domain\ValueObject\MovieName;
use App\Movies\Domain\Exception\MovieAlreadyExists;

/**
 * Service responsible for creating movies.
 */
final readonly class MovieCreator
{
    /**
     * Constructs a new MovieCreator instance.
     *
     * @param MovieRepository $movieRepository The repository for managing movies.
     */
    public function __construct(
        private MovieRepository $movieRepository
    ) {
    }

    /**
     * Creates a new movie based on the provided MovieDTO.
     *
     * Ensures that the movie does not already exist with the same name.
     *
     * @param MovieDTO $movieDto The DTO containing movie information.
     * @return Movie The created movie entity.
     */
    public function createMovie(
        MovieDTO $movieDto
    ): Movie
    {
        $this->ensureMovieNotExist(MovieName::fromString($movieDto->movieBasic->movieName));
        $movie = Movie::create(
            $movieDto->movieBasic->toArray(),
            $movieDto->movieDetailsParameters->toArray(),
        );
        $this->movieRepository->add($movie);
        return $movie;
    }

    /**
     * Ensure that a movie with the given name does not already exist.
     * @param MovieName $movieName The name of the movie to check.
     * @throws MovieAlreadyExists If a movie with the given name already exists.
     */
    private function ensureMovieNotExist(MovieName $movieName): void
    {
        $existingMovie = $this->movieRepository->findByMovieName($movieName);
        if ($existingMovie !== null) {
            throw new MovieAlreadyExists($movieName);
        }
    }
}
