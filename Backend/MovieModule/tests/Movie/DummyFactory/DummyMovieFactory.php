<?php
namespace App\Tests\Movie\DummyFactory;

use App\Movies\Application\DTO\MovieBasicDTO;
use App\Movies\Application\DTO\MovieDetailsParameterDTO;
use App\Movies\Domain\Entity\Movie;
use App\Movies\Domain\ValueObject\AgeRestriction;
use App\Movies\Domain\ValueObject\AverageRating;
use App\Movies\Domain\ValueObject\Description;
use App\Movies\Domain\ValueObject\Duration;
use App\Movies\Domain\ValueObject\MovieName;
use App\Movies\Domain\ValueObject\ReleaseYear;
use Faker\Factory;
use Faker\Generator;

class DummyMovieFactory
{
    private function __construct() {
    }

    public static function createMovie(): Movie
    {
        $faker = Factory::create();
        $movieBasicData = self::generateMovieBasicData($faker);
        $movieDetailsParameters = self::generateMovieDetailsParamData($faker);

        return Movie::create(
            MovieName::fromString($movieBasicData->movieName),
            Description::fromString($movieBasicData->description),
            ReleaseYear::fromString($movieBasicData->releaseYear),
            $movieDetailsParameters->toArray(),
            Duration::fromInt($movieBasicData->duration),
            AgeRestriction::fromInt($movieBasicData->ageRestriction),
            AverageRating::fromFloat($movieBasicData->averageRating),
        );
    }

    /**
     * Generates random basic data for movie.
     *
     * @param Generator $faker The Faker generator instance.
     * @return MovieBasicDTO The generated movie basic data.
     */
    public static function generateMovieBasicData(Generator $faker): MovieBasicDTO
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
     * Generates random details parameter data for movie.
     *
     * @param Generator $faker The Faker generator instance.
     * @return MovieDetailsParameterDTO The generated movie details parameter data.
     */
    public static function generateMovieDetailsParamData(Generator $faker): MovieDetailsParameterDTO
    {
        return new MovieDetailsParameterDTO(
            productionCountry: [$faker->country()],
            directors: [$faker->name()],
            actors: [$faker->name()],
            category: [$faker->randomElement(['Action', 'Comedy', 'Drama', 'Thriller'])],
            tags: [$faker->randomElement(['Adventure', 'Romance', 'Sci-Fi', 'Horror'])],
            languages: [$faker->languageCode()],
            subtitles: [$faker->randomElement(['English', 'Spanish', 'French', 'German'])]
        );
    }
}
