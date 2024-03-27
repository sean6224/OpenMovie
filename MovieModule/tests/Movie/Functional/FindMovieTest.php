<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use App\Common\Application\Query\QueryBus;
use App\Movies\Application\UseCase\Query\GetMovie\GetMovieQuery;
use App\Tests\Movie\DummyFactory\DummyMovieFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Movies\Domain\Repository\MovieRepository;
use Exception;

/**
 * Functional tests for finding movies.
 */
class FindMovieTest extends KernelTestCase
{
    /**
     * Test to find movie.
     *
     * @return void
     * @throws Exception
     */
    public function testFindMovie(): void
    {
        $movieRepository = static::getContainer()->get(MovieRepository::class);
        $queryBus = static::getContainer()->get(QueryBus::class);

        $movie = DummyMovieFactory::createMovie();
        $movieRepository->add($movie);
        $retrievedMovie = $queryBus->ask(
            new GetMovieQuery(
                $movie->id()->value()
            )
        );

        static::assertSame(
            $movie->id()->value(),
            $retrievedMovie->id,
            'Retrieved movie ID does not match expected movie ID'
        );
    }
}
