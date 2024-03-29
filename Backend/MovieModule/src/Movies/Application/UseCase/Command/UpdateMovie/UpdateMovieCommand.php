<?php

namespace App\Movies\Application\UseCase\Command\UpdateMovie;

use App\Common\Application\Command\Command;
use App\Movies\Application\DTO\MovieBasicDTO;
use App\Movies\Application\DTO\MovieDetailsParameterDTO;
use App\Movies\Application\DTO\MovieDTO;

/**
 * Command object representing a request to update a movie.
 */
class UpdateMovieCommand implements Command
{
    public function __construct(
        public string $movieId,
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
            id: $this->movieId,
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
