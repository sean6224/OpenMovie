<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use App\Common\Application\Command\CommandBus;
use App\Movies\Application\DTO\MovieBasicDTO;
use App\Movies\Application\DTO\MovieDetailsParameterDTO;
use App\Movies\Application\UseCase\Command\CreateMovie\CreateMovieCommand;
use App\Movies\Domain\Repository\MovieRepository;
use App\Movies\Domain\Entity\Movie;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Functional test case for creating movie.
 */
final class CreateMovieTest extends KernelTestCase
{
    /**
     * Tests the creation of movie.
     *
     * @throws Exception
     */
    public function testCreateMovie(): void
    {
        self::bootKernel();
        $container = self::getContainer();
        $movieRepository = $container->get(MovieRepository::class);
        $commandBus = $container->get(CommandBus::class);

        $faker = Factory::create();
        $movieBasicData = $this->generateMovieBasicData($faker);
        $movieDetailsParamData = $this->generateMovieDetailsParamData($faker);

        $movieDTO = new CreateMovieCommand(
            movieName: $movieBasicData->movieName,
            description: $movieBasicData->description,
            releaseYear: $movieBasicData->releaseYear,
            movieData: $movieDetailsParamData,
            duration: $movieBasicData->duration,
            ageRestriction: $movieBasicData->ageRestriction,
            averageRating: $movieBasicData->averageRating
        );
        $commandBus->dispatch($movieDTO);

        $movies = $movieRepository->findAll();
        $this->assertNotEmpty($movies, 'No movies found in the repository.');

        $movie = $movies[0];
        $this->assertInstanceOf(Movie::class, $movie, 'Failed to fetch movie from the repository.');

    }

    /**
     * Generates basic data for movie.
     *
     * @param Generator $faker
     *
     * @return MovieBasicDTO
     */
    private function generateMovieBasicData(Generator $faker): MovieBasicDTO
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
     * @param Generator $faker
     *
     * @return MovieDetailsParameterDTO
     */
    private function generateMovieDetailsParamData(Generator $faker): MovieDetailsParameterDTO
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
