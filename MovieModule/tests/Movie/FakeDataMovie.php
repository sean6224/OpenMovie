<?php
declare(strict_types=1);
namespace App\Tests\Movie;

use App\Common\Application\Command\CommandBus;
use App\Movies\Application\DTO\MovieBasicDTO;
use App\Movies\Application\DTO\MovieDetailsParameterDTO;
use App\Movies\Application\UseCase\Command\CreateMovie\CreateMovieCommand;
use App\Movies\Domain\Entity\Movie;
use App\Movies\Domain\Repository\MovieRepository;
use App\Movies\Domain\ValueObject\AgeRestriction;
use App\Movies\Domain\ValueObject\AverageRating;
use App\Movies\Domain\ValueObject\Description;
use App\Movies\Domain\ValueObject\Duration;
use App\Movies\Domain\ValueObject\MovieName;
use App\Movies\Domain\ValueObject\ReleaseYear;
use Faker\Factory;
use Faker\Generator;

class FakeDataMovie
{
    private ?CommandBus $commandBus;
    private ?MovieRepository $movieRepository;
    private Generator $faker;

    public function __construct(CommandBus $commandBus = null, MovieRepository $movieRepository = null)
    {
        $this->commandBus = $commandBus;
        $this->movieRepository = $movieRepository;
        $this->faker = Factory::create();
    }

    /**
     * Creates movies using generated data.
     *
     * @param bool $return Whether to return the ID of last created movie.
     * @return string|null The ID of last created movie or null if no movies were created or $return is false.
     */
    public function createMovie(bool $return = false): ?string
    {
        $lastMovieId = null;
        $movieBasicData = $this->generateMovieBasicData();
        $movieDetailsParamData = $this->generateMovieDetailsParamData();

        $createMovieCommand = new CreateMovieCommand(
            movieName: $movieBasicData->movieName,
            description: $movieBasicData->description,
            releaseYear: $movieBasicData->releaseYear,
            movieData: $movieDetailsParamData,
            duration: $movieBasicData->duration,
            ageRestriction: $movieBasicData->ageRestriction,
            averageRating: $movieBasicData->averageRating
        );
        $this->commandBus->dispatch($createMovieCommand);
        if ($return) {
            $lastMovieId = $this->getLastMovieId();
        }
        return $return ? $lastMovieId : null;
    }

    /**
     * Get ID of last movie in repository.
     *
     * @return string|null The ID of last movie or null if no movies are found.
     */
    private function getLastMovieId(): ?string
    {
        $lastMovie = $this->movieRepository->findLastMovie();
        return $lastMovie?->id()->value();
    }

    /**
     * Generates movie using generated basic and detailed data.
     *
     * This method is intended for use in integration tests only.
     *
     * @return Movie The generated movie.
     */
    private function generateMovie(): Movie
    {
        $movieBasicData = $this->generateMovieBasicData();
        $movieDetailsParamData = $this->generateMovieDetailsParamData();

        return Movie::create(
            MovieName::fromString($movieBasicData->movieName),
            Description::fromString($movieBasicData->description),
            ReleaseYear::fromString($movieBasicData->releaseYear),
            $movieDetailsParamData->toArray(),
            Duration::fromInt($movieBasicData->duration),
            AgeRestriction::fromInt($movieBasicData->ageRestriction),
            AverageRating::fromFloat($movieBasicData->averageRating)
        );
    }

    /**
     * Generates data for movie.
     *
     * @param int $index The index of movie.
     * @return array The movie data.
     */
    public function generateMovieData(int $index): array
    {
        $movieBasicData = $this->generateMovieBasicData()->toArray();
        $movieDetailsParamData = $this->generateMovieDetailsParamData()->toArray();

        return [
            'movieInformation' => [
                'movieName' => 'Test Movie 4' . $index,
                'description' => $movieBasicData['description'],
                'releaseYear' => $movieBasicData['releaseYear'],
                'productionCountry' => $movieDetailsParamData['productionCountry'],
                'directors' => $movieDetailsParamData['directors'],
                'actors' => $movieDetailsParamData['actors'],
                'category' => $movieDetailsParamData['category'],
                'tags' => $movieDetailsParamData['tags'],
                'languages' => $movieDetailsParamData['languages'],
                'subtitles' => $movieDetailsParamData['subtitles'],
                'duration' => $movieBasicData['duration'],
                'ageRestriction' => $movieBasicData['ageRestriction'],
                'averageRating' => $movieBasicData['averageRating']
            ]
        ];
    }

    /**
     * Generates basic data for movie.
     *
     * @return MovieBasicDTO The basic movie data.
     */
    public function generateMovieBasicData(): MovieBasicDTO
    {
        return new MovieBasicDTO(
            movieName: $this->faker->name(),
            description: $this->faker->sentence(),
            releaseYear: $this->faker->year(),
            duration: $this->faker->numberBetween(0, 90),
            ageRestriction: $this->faker->numberBetween(0, 1500),
            averageRating: $this->faker->randomFloat(1, 1, 10)
        );
    }

    /**
     * Generates detailed data for movie.
     *
     * @return MovieDetailsParameterDTO The detailed movie data.
     */
    public function generateMovieDetailsParamData(): MovieDetailsParameterDTO
    {
        return new MovieDetailsParameterDTO(
            productionCountry: [$this->faker->country()],
            directors: [$this->faker->name()],
            actors: [$this->faker->name()],
            category: [$this->faker->word()],
            tags: [$this->faker->word()],
            languages: [$this->faker->locale()],
            subtitles: [$this->faker->word()]
        );
    }
}
