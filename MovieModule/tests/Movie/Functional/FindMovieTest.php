<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Common\Application\Command\CommandBus;
use App\Common\Application\Query\QueryBus;
use App\Movies\Application\DTO\MovieDTO;
use App\Movies\Application\UseCase\Query\GetMovie\GetMovieQuery;
use App\Movies\Domain\Repository\MovieRepository;
use App\Movies\Application\DTO\MovieBasicDTO;
use App\Movies\Application\DTO\MovieDetailsParameterDTO;
use App\Movies\Domain\Entity\Movie;
use App\Movies\Application\UseCase\Command\CreateMovie\CreateMovieCommand;
use Exception;
use Faker\Factory;

/**
 * Functional tests for finding movies.
 */
class FindMovieTest extends KernelTestCase
{
    private static CommandBus $commandBus;
    private static QueryBus $queryBus;
    private static MovieRepository $movieRepository;

    /**
     * Sets up the test class before running the tests.
     *
     * @return void
     * @throws Exception
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        static::$commandBus = static::getContainer()->get(CommandBus::class);
        static::$queryBus = static::getContainer()->get(QueryBus::class);
        static::$movieRepository = static::getContainer()->get(MovieRepository::class);
    }

    /**
     * Test to find a movie.
     *
     * @return void
     * @throws Exception
     */
    public function testFindMovie(): void
    {
        $movieId = $this->createMovie();
        $movieDTO = self::$queryBus->ask(new GetMovieQuery(movieId: $movieId));
        static::assertInstanceOf(MovieDTO::class, $movieDTO);
    }

    /**
     * Creates movie for testing.
     *
     * @return string The ID of the created movie.
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
     * Generates basic data for movie.
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
     * Generates detailed data for movie.
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
