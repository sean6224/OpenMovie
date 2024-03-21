<?php
declare(strict_types=1);
namespace App\Tests\Movie\DummyFactory;

use App\Movies\Application\DTO\MovieBasicDTO;
use App\Movies\Domain\ValueObject\AgeRestriction;
use App\Movies\Domain\ValueObject\AverageRating;
use App\Movies\Domain\ValueObject\Description;
use App\Movies\Domain\ValueObject\Duration;
use App\Movies\Domain\ValueObject\MovieName;
use App\Movies\Domain\ValueObject\ReleaseYear;
use Faker\Factory;
use App\Movies\Application\DTO\MovieDetailsParameterDTO;
use App\Movies\Domain\Entity\Movie;

final class DummyMovieFactoryTest
{
    public function __construct()
    {
    }

    public function testCreateMovie(): Movie
    {
        $faker = Factory::create();
        $movieBasicData = $this->generateMovieBasicData($faker);
        $movieDetailsParamData = $this->generateMovieDetailsParamData($faker);

        return Movie::create(
            MovieName::fromString($movieBasicData->movieName),
            Description::fromString($movieBasicData->description),
            ReleaseYear::fromString($movieBasicData->releaseYear),
            $movieDetailsParamData->toArray(),
            Duration::fromInt($movieBasicData->duration),
            AgeRestriction::fromInt($movieBasicData->ageRestriction),
            AverageRating::fromFloat($movieBasicData->averageRating),
        );
    }

    /**
     * Generates basic data for movie.
     *
     * @param mixed $faker The Faker instance.
     *
     * @return MovieBasicDTO The generated basic movie data.
     */
    private function generateMovieBasicData(mixed $faker): MovieBasicDTO
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
     * @param mixed $faker The Faker instance.
     *
     * @return MovieDetailsParameterDTO The generated detailed movie data.
     */
    private function generateMovieDetailsParamData(mixed $faker): MovieDetailsParameterDTO
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
