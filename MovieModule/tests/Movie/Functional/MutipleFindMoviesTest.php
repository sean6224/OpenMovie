<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use App\Tests\Movie\FakeDataMovie;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Common\Application\Command\CommandBus;
use App\Common\Application\Query\QueryBus;
use App\Movies\Application\DTO\MovieDTO;
use App\Movies\Application\UseCase\Query\SearchMoviesPaginatedQuery\SearchMoviesPaginatedQuery;
use App\Movies\Domain\Repository\MovieRepository;
use Exception;

/**
 * Functional tests for finding multiple movies.
 */
class MutipleFindMoviesTest extends KernelTestCase
{
    private static CommandBus $commandBus;
    private static QueryBus $queryBus;
    private static MovieRepository $movieRepository;
    private static FakeDataMovie $fakeDataMovie;

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
        static::$fakeDataMovie = new FakeDataMovie(static::$commandBus, static::$movieRepository);
    }

    /**
     * Test to find multiple movies.
     *
     * @throws Exception
     */
    public function testFindMovies(): void
    {
        for ($i = 0; $i < 5; $i++) {
            static::$fakeDataMovie->createMovie();
        }

        $movies = self::$queryBus->ask(new SearchMoviesPaginatedQuery(1, 20));
        $this->assertNotEmpty($movies, 'No movies found.');

        foreach ($movies as $movieDTO) {
            static::assertInstanceOf(MovieDTO::class, $movieDTO);
        }
    }
}
