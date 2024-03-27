<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use App\Tests\Movie\DummyFactory\DummyMovieFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Movies\Domain\Repository\MovieRepository;
use Exception;

/**
 * Functional tests for finding multiple movies.
 */
class MutipleFindMoviesTest extends KernelTestCase
{
    private static MovieRepository $movieRepository;

    /**
     * Sets up test class before running tests.
     *
     * @throws Exception
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        static::$movieRepository = static::getContainer()->get(MovieRepository::class);
    }

    /**
     * Test to find multiple movies.
     *
     * @throws Exception
     */
    public function testFindMovies(): void
    {
        for ($i = 0; $i < 5; $i++) {
            DummyMovieFactory::createMovie();
        }

        $movies = self::$movieRepository->search(
            1,
            20,
            'releaseYear',
            'asc'
        );
        $this->assertNotEmpty($movies, 'No movies found.');
    }
}
