<?php
declare(strict_types=1);
namespace App\Movies\Application\Service;

use App\Common\Domain\ValueObject\Id;
use App\Movies\Domain\Repository\MovieRepository;
use App\Movies\Domain\Entity\Movie;
use App\Movies\Application\DTO\MovieDTO;

use App\Movies\Domain\ValueObject\MovieName;
use App\Movies\Domain\ValueObject\Description;
use App\Movies\Domain\ValueObject\ReleaseYear;
use App\Movies\Domain\ValueObject\Duration;
use App\Movies\Domain\ValueObject\AgeRestriction;

/**
 * Service class responsible for patching (partially updating) movie entities.
 */
final readonly class PatchMovie
{
    /**
     * Constructs a new PatchMovie instance.
     *
     * @param MovieRepository $movieRepository The repository for movie entities.
     */
    public function __construct(
        private MovieRepository $movieRepository
    ) {
    }

    /**
     * Patch (partially update) a movie entity based on the provided DTO.
     *
     * @param MovieDTO $movieDto The DTO containing movie data to be patched.
     * @return Movie The patched movie entity.
     */
    public function patchMovie(
        MovieDTO $movieDto
    ): Movie
    {
        $movieDTO = $movieDto->movieBasic;
        $movie = $this->movieRepository->get(Id::fromString($movieDto->id));
        $movie->update(
            MovieName::fromString($movieDTO->movieName),
            Description::fromString($movieDTO->description),
            ReleaseYear::fromString($movieDTO->releaseYear),
            $movieDto->movieDetailsParameters->toArray(),
            Duration::fromInt($movieDTO->duration),
            AgeRestriction::fromInt($movieDTO->ageRestriction)
        );
        return $movie;
    }
}
