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
     * Constructs new CreateMovieCommand instance.
     *
     * @param MovieBasicDTO $movieBasicDTO The parameters of movie.
     * @param MovieDetailsParameterDTO $movieDetailsDTO The details parameters of movie.
     */
    public function __construct(
        public MovieBasicDTO            $movieBasicDTO,
        public MovieDetailsParameterDTO $movieDetailsDTO,
    ) {
    }

    /**
     * Converts current object to MovieDTO object.
     *
     * @return MovieDTO Returns new instance of MovieDTO.
     */
    public function toDto(): MovieDTO
    {
        $movieBasicDTO = $this->movieBasicDTO;
        $movieDetailsDTO = $this->movieDetailsDTO;
        return new MovieDTO(
            id: '',
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
