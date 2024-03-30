<?php
declare(strict_types=1);

namespace App\Movies\UserInterface\ApiPlatform\Output;

use App\Movies\UserInterface\ApiPlatform\Resource\MovieResource;

/**
 * Represents the output of a movie search operation.
 */
final class MovieSearchOutput
{
    /**
     * @var MovieResource[]
     */
    private array $movies;

    /**
     * Constructs a new MovieSearchOutput instance.
     *
     * @param MovieResource[] $movies The movie resources
     */
    public function __construct(array $movies)
    {
        $this->movies = $movies;
    }

    /**
     * Gets the movie resources.
     *
     * @return MovieResource[]
     */
    public function getMovies(): array
    {
        return $this->movies;
    }
}
