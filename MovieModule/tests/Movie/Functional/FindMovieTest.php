<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use App\Tests\Movie\DummyFactory\DummyMovieFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Movies\Domain\Repository\MovieRepository;
use Exception;

/**
 * Functional tests for finding movies.
 */
class FindMovieTest extends KernelTestCase
{
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
        static::$movieRepository = static::getContainer()->get(MovieRepository::class);
    }

    /**
     * Test to find movie.
     *
     * @return void
     * @throws Exception
     */
    public function testFindMovie(): void
    {
        DummyMovieFactory::createMovie();
        $lastMovie = static::$movieRepository->findLastMovie();
        $movie = static::$movieRepository->get($lastMovie->id());
        static::assertNotNull($movie, 'Movie not found in the repository.');
    }
}
