<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Common\Application\Command\CommandBus;
use App\Common\Application\Query\QueryBus;
use App\Movies\Application\DTO\MovieDTO;
use App\Movies\Application\UseCase\Query\SearchMoviesPaginatedQuery\SearchMoviesPaginatedQuery;
use App\Movies\Domain\Repository\MovieRepository;
use App\Movies\Application\DTO\MovieBasicDTO;
use App\Movies\Application\DTO\MovieDetailsParameterDTO;
use App\Movies\Domain\Entity\Movie;
use App\Movies\Application\UseCase\Command\CreateMovie\CreateMovieCommand;
use Exception;
use Faker\Factory;

/**
 * Functional tests for finding multiple movies.
 */
class MutipleFindMoviesTest extends KernelTestCase
{
    private static CommandBus $commandBus;
    private static QueryBus $queryBus;
    private static MovieRepository $movieRepository;

    /**
     * Sets up test class before running tests.
     *
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
     * Test to find multiple movies.
     *
     * @throws Exception
     */
    public function testFindMovies(): void
    {
        $numberOfMovies = 5;
        for ($i = 0; $i < $numberOfMovies; $i++) {
            $this->createMovie();
        }

        $movies = self::$queryBus->ask(new SearchMoviesPaginatedQuery(1, 20));

        // Assert
        $this->assertNotEmpty($movies, 'No movies found.');
        foreach ($movies as $movieDTO) {
            static::assertInstanceOf(MovieDTO::class, $movieDTO);
        }
    }


    /**
     * Creates movie for testing.
     *
     * @return void
     */
    private function createMovie(): void
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
    }

    /**
     * Generates basic data for movie.
     *
     * @return MovieBasicDTO The basic movie data.
     */
    private function generateMovieBasicData($faker): MovieBasicDTO
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
