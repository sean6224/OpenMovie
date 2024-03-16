<?php
declare(strict_types=1);
namespace App\Movies\Application\DTO;

use App\Movies\Domain\Entity\Movie;

/**
 * Represents a Data Transfer Object (DTO) for a Movie entity.
 */
final readonly class MovieDTO
{
    /**
     * Constructs a new MovieDTO instance.
     *
     * @param string $id The ID of the movie.
     * @param MovieBasicDTO $movieBasic The basic information of the movie.
     * @param MovieDetailsParameterDTO $movieDetailsParameters The details parameters of the movie.
     */
    public function __construct(
        public string $id,
        public MovieBasicDTO $movieBasic,
        public MovieDetailsParameterDTO $movieDetailsParameters
    ) {
    }

    /**
     * Creates a MovieDTO instance from a Movie entity.
     *
     * @param Movie $movie The Movie entity to create the DTO from.
     * @return MovieDTO The created MovieDTO instance.
     */
    public static function fromEntity(Movie $movie): MovieDTO
    {

        $movieData = new MovieBasicDTO(
            movieName: (string)$movie->getMovieName(),
            description: (string)$movie->getDescription(),
            releaseYear: (string)$movie->getReleaseYear(),
            duration: $movie->getDuration()->value(),
            ageRestriction: $movie->getAgeRestriction()->value(),
        );

        return new self(
            id: (string)$movie->id(),
            movieBasic: $movieData,

            movieDetailsParameters: new MovieDetailsParameterDTO(
                productionCountry: $movie->productionCountry(),
                directors: $movie->Directors(),
                actors: $movie->Actors(),
                category: $movie->Category(),
                tags: $movie->productionCountry(),
                languages: $movie->Languages(),
                subtitles: $movie->Subtitles(),
            )
        );
    }
}
