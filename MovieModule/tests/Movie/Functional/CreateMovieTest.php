<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use App\Movies\Domain\Repository\MovieRepository;
use App\Movies\Domain\Entity\Movie;
use App\Tests\Movie\DummyFactory\DummyMovieFactory;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Functional test case for creating movie.
 */
class CreateMovieTest extends KernelTestCase
{
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
        static::$movieRepository = static::getContainer()->get(MovieRepository::class);
    }

    /**
     * Tests the creation of movie.
     *
     * @throws Exception
     */
    public function testCreateMovie(): void
    {
        DummyMovieFactory::createMovie();
        $movies = static::$movieRepository->findLastMovie();
        $this->assertNotEmpty($movies, 'No movies found in repository.');
        $this->assertInstanceOf(Movie::class, $movies, 'Failed to fetch movie from repository.');
    }
}
