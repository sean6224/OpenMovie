<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use App\Tests\Movie\FakeDataMovie;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Common\Application\Command\CommandBus;
use App\Common\Application\Query\QueryBus;
use App\Movies\Application\DTO\MovieDTO;
use App\Movies\Application\UseCase\Query\GetMovie\GetMovieQuery;
use App\Movies\Domain\Repository\MovieRepository;
use Exception;

/**
 * Functional tests for finding movies.
 */
class FindMovieTest extends KernelTestCase
{
    private static CommandBus $commandBus;
    private static QueryBus $queryBus;
    private static MovieRepository $movieRepository;
    private static FakeDataMovie $fakeDataMovie;

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
        static::$fakeDataMovie = new FakeDataMovie(static::$commandBus, static::$movieRepository);
    }

    /**
     * Test to find movie.
     *
     * @return void
     * @throws Exception
     */
    public function testFindMovie(): void
    {
        $movieId = static::$fakeDataMovie->createMovie(true);
        $movieDTO = self::$queryBus->ask(new GetMovieQuery(movieId: $movieId));
        static::assertInstanceOf(MovieDTO::class, $movieDTO);
    }
}
