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
        public MovieBasicDTO            $movieBasicDTO,
        public MovieDetailsParameterDTO $movieDetailsDTO
    ) {
    }

    /**
     * Converts the current object to a MovieDTO object.
     *
     * @return MovieDTO Returns a new instance of MovieDTO.
     */
    public function toDto(): MovieDTO
    {
        $movieBasicDTO = $this->movieBasicDTO;
        $movieDetailsDTO = $this->movieDetailsDTO;
        return new MovieDTO(
            id: $this->movieId,
            movieBasic: new MovieBasicDTO(
                movieName: $movieBasicDTO->movieName,
                description: $movieBasicDTO->description,
                releaseYear: $movieBasicDTO->releaseYear,
                duration: $movieBasicDTO->duration,
                ageRestriction: $movieBasicDTO->ageRestriction,
                averageRating: $movieBasicDTO->averageRating,
                productionCountry: $movieBasicDTO->productionCountry,
            ),

            movieDetailsParameters: new MovieDetailsParameterDTO(
                productionLocations: $movieDetailsDTO->productionLocations,
                directors: $movieDetailsDTO->directors,
                actors: $movieDetailsDTO->actors,
                category: $movieDetailsDTO->category,
                languages: $movieDetailsDTO->languages,
                subtitles: $movieDetailsDTO->subtitles,
            )
        );
    }
}
