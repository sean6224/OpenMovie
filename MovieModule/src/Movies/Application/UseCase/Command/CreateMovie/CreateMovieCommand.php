<?php
declare(strict_types=1);
namespace App\Movies\Application\UseCase\Command\CreateMovie;

use App\Common\Application\Command\Command;
use App\Movies\Application\DTO\MovieBasicDTO;
use App\Movies\Application\DTO\MovieDetailsParameterDTO;
use App\Movies\Application\DTO\MovieDTO;

/**
 * Represents a command for creating a movie.
 */
final class CreateMovieCommand implements Command
{
    /**
     * Constructs a new CreateMovieCommand instance.
     *
     * @param string $movieName The name of the movie.
     * @param string $description The description of the movie.
     * @param string $releaseYear The release year of the movie.
     * @param MovieDetailsParameterDTO $movieData The details parameters of the movie.
     * @param int $duration The duration of the movie.
     * @param int $ageRestriction The age restriction of the movie.
     */
    public function __construct(
        public string $movieName,
        public string $description,
        public string $releaseYear,
        public MovieDetailsParameterDTO $movieData,
        public int $duration,
        public int $ageRestriction
    ) {
    }

    /**
     * Converts the current object to a MovieDTO object.
     *
     * @return MovieDTO Returns a new instance of MovieDTO.
     */
    public function toDto(): MovieDTO
    {
        return new MovieDTO(
            id: uuid_create(),
            movieBasic: new MovieBasicDTO(
                movieName: $this->movieName,
                description: $this->description,
                releaseYear: $this->releaseYear,
                duration: $this->duration,
                ageRestriction: $this->ageRestriction
            ),

            movieDetailsParameters: new MovieDetailsParameterDTO(
                productionCountry: $this->movieData->productionCountry,
                directors: $this->movieData->directors,
                actors: $this->movieData->actors,
                category: $this->movieData->category,
                tags: $this->movieData->tags,
                languages: $this->movieData->languages,
                subtitles: $this->movieData->subtitles,
            )
        );
    }
}
