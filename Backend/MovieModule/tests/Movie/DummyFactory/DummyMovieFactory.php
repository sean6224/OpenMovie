<?php
namespace App\Tests\Movie\DummyFactory;

use App\Movies\Application\DTO\MovieBasicDTO;
use App\Movies\Application\DTO\MovieDetailsParameterDTO;
use App\Movies\Domain\Entity\Movie;
use Faker\Factory;
use Faker\Generator;

class DummyMovieFactory
{
    private function __construct() {
        //Empty __construct
    }

    public static function createMovie(): Movie
    {
        $faker = Factory::create();
        $movieBasicData = self::generateMovieBasicData($faker);
        $movieDetailsParameters = self::generateMovieDetailsParamData($faker);

        return Movie::create(
            $movieBasicData->toArray(),
            $movieDetailsParameters->toArray(),
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
            averageRating: $faker->randomFloat(1, 1, 10),
            productionCountry: $faker->country()
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
            productionLocations: [$faker->country()],
            directors: [$faker->name()],
            actors: [$faker->name()],
            category: [$faker->randomElement(['Action', 'Comedy', 'Drama', 'Thriller'])],
            languages: [$faker->languageCode()],
            subtitles: [$faker->randomElement(['English', 'Spanish', 'French', 'German'])]
        );
    }
}
