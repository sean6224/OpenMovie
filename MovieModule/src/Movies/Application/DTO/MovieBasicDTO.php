<?php
declare(strict_types=1);
namespace App\Movies\Application\DTO;

/**
 * Represents a Data Transfer Object (DTO) for basic information of a movie.
 */
final readonly class MovieBasicDTO
{
    /**
     * Constructs a new MovieBasicDTO instance.
     *
     * @param string $movieName The name of the movie.
     * @param string $description The description of the movie.
     * @param string $releaseYear The release year of the movie.
     * @param int $duration The duration of the movie in minutes.
     * @param int $ageRestriction The age restriction for the movie.
     */
    public function __construct(
        public string $movieName,
        public string $description,
        public string $releaseYear,
        public int $duration,
        public int $ageRestriction
    ) {
    }
}