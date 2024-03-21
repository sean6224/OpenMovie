<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Common\Application\Command\CommandBus;
use App\Movies\Domain\Repository\MovieRepository;
use App\Movies\Application\DTO\MovieBasicDTO;
use App\Movies\Application\DTO\MovieDetailsParameterDTO;
use App\Movies\Domain\Entity\Movie;
use App\Movies\Application\UseCase\Command\CreateMovie\CreateMovieCommand;
use App\Movies\Application\UseCase\Command\DeleteMovie\DeleteMovieCommand;
use Exception;
use Faker\Factory;
/**
 * Functional test case for creating and deleting movies.
 */
class CreateDeleteTest extends KernelTestCase
{
    private static CommandBus $commandBus;
    private static MovieRepository $movieRepository;

    /**
     * Sets up the test class before running tests.
     *
     * @return void
     * @throws Exception
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        static::$commandBus = static::getContainer()->get(CommandBus::class);
        static::$movieRepository = static::getContainer()->get(MovieRepository::class);
    }

    /**
     * Test for deleting movie.
     *
     * @return void
     * @throws Exception
     */
    public function testDeleteMovie(): void
    {
        $movieId = $this->createMovie();
        $deleteMovieCommand = new DeleteMovieCommand($movieId);
        static::$commandBus->dispatch($deleteMovieCommand);
    }

    /**
     * Creates movie for testing.
     *
     * @return string The ID of the created movie.
     * @throws Exception
     */
    private function createMovie(): string
    {
        $faker = Factory::create();
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
        static::$commandBus->dispatch($createMovieCommand);

        $movies = static::$movieRepository->findAll();
        $this->assertNotEmpty($movies, 'No movies found in the repository.');
        $movie = $movies[0];
        $this->assertInstanceOf(Movie::class, $movie, 'Failed to fetch movie from the repository.');
        return $movie->id()->value();
    }

    /**
     * Generates basic data for a movie.
     *
     * @return MovieBasicDTO The basic movie data.
     */
    private function generateMovieBasicData($faker): MovieBasicDTO
    {
        return new MovieBasicDTO(
            movieName: 'test movie',
            description: $faker->sentence(),
            releaseYear: $faker->year(),
            duration: $faker->numberBetween(0, 90),
            ageRestriction: $faker->numberBetween(0, 1500),
            averageRating: $faker->randomFloat(1, 1, 10)
        );
    }

    /**
     * Generates detailed data for a movie.
     *
     * @return MovieDetailsParameterDTO The detailed movie data.
     */
    private function generateMovieDetailsParamData($faker): MovieDetailsParameterDTO
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
