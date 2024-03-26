<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use App\Common\Application\Command\CommandBus;
use App\Movies\Domain\Repository\MovieRepository;
use App\Movies\Domain\Entity\Movie;
use App\Tests\Movie\FakeDataMovie;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Functional test case for creating movie.
 */
class CreateMovieTest extends KernelTestCase
{
    private static CommandBus $commandBus;
    private static MovieRepository $movieRepository;
    private static FakeDataMovie $fakeDataMovie;

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
        static::$fakeDataMovie = new FakeDataMovie(static::$commandBus, static::$movieRepository);
    }

    /**
     * Tests the creation of movie.
     *
     * @throws Exception
     */
    public function testCreateMovie(): void
    {
        static::$fakeDataMovie->createMovie();
        $movies = static::$movieRepository->findLastMovie();

        $this->assertNotEmpty($movies, 'No movies found in the repository.');
        $this->assertInstanceOf(Movie::class, $movies, 'Failed to fetch movie from the repository.');
    }
}
