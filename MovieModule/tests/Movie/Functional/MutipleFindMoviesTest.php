<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use App\Common\Application\Query\QueryBus;
use App\Movies\Application\UseCase\Query\SearchMoviesPaginatedQuery\SearchMoviesPaginatedQuery;
use App\Tests\Movie\DummyFactory\DummyMovieFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Movies\Domain\Repository\MovieRepository;
use Exception;

/**
 * Functional tests for finding multiple movies.
 */
class MutipleFindMoviesTest extends KernelTestCase
{
    /**
     * Test to find multiple movies.
     *
     * @throws Exception
     */
    public function testFindMovies(): void
    {
        $movieRepository = static::getContainer()->get(MovieRepository::class);
        $queryBus = static::getContainer()->get(QueryBus::class);

        $initialMovies = array_map(static function () {
            return DummyMovieFactory::createMovie();
        }, range(1, 5));

        foreach ($initialMovies as $movie) {
            $movieRepository->add($movie);
        }

        $movies = $queryBus->ask(
            new SearchMoviesPaginatedQuery(1, 5)
        );

        static::assertCount(count($initialMovies), $movies);
    }
}
