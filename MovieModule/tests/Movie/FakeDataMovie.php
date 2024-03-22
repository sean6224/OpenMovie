<?php

namespace App\Tests\Movie;

use App\Common\Application\Command\CommandBus;
use App\Movies\Application\DTO\MovieBasicDTO;
use App\Movies\Application\DTO\MovieDetailsParameterDTO;
use App\Movies\Application\UseCase\Command\CreateMovie\CreateMovieCommand;
use App\Movies\Domain\Repository\MovieRepository;
use Faker\Factory;

class FakeDataMovie
{
    private CommandBus $commandBus;
    private MovieRepository $movieRepository;
    public function __construct(CommandBus $commandBus, MovieRepository $movieRepository)
    {
        $this->commandBus = $commandBus;
        $this->movieRepository = $movieRepository;
    }

    public function createMovie(int $count, bool $return = false): ?string
    {
        $faker = Factory::create();

        for ($i = 0; $i < $count; $i++) {
            $movieBasicData = $this->generateMovieBasicData($faker);
            $movieDetailsParamData = $this->generateMovieDetailsParamData($faker);
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
                $movies = $this->movieRepository->findAll();
                $movie = end($movies);
                return $movie->id()->value();
            }
        }
        return null;
    }

    /**
     * Generates basic data for movie.
     *
     * @return MovieBasicDTO The basic movie data.
     */
    public function generateMovieBasicData($faker): MovieBasicDTO
    {
        return new MovieBasicDTO(
            movieName: $faker->name(),
            description: $faker->sentence(),
            releaseYear: $faker->year(),
            duration: $faker->numberBetween(0, 90),
            ageRestriction: $faker->numberBetween(0, 1500),
            averageRating: $faker->randomFloat(1, 1, 10)
        );
    }

    /**
     * Generates detailed data for movie.
     *
     * @return MovieDetailsParameterDTO The detailed movie data.
     */
    public function generateMovieDetailsParamData($faker): MovieDetailsParameterDTO
    {
        return new MovieDetailsParameterDTO(
            productionCountry: [$faker->country()],
            directors: [$faker->name()],
            actors: [$faker->name()],
            category: [$faker->word()],
            tags: [$faker->word()],
            languages: [$faker->locale()],
            subtitles: [$faker->word()]
        );
    }
}
