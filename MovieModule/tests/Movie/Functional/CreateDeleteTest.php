<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use App\Tests\Movie\FakeDataMovie;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Common\Application\Command\CommandBus;
use App\Movies\Domain\Repository\MovieRepository;
use App\Movies\Application\UseCase\Command\DeleteMovie\DeleteMovieCommand;
use Exception;

/**
 * Functional test case for creating and deleting movies.
 */
class CreateDeleteTest extends KernelTestCase
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
     * Test for deleting movie.
     *
     * @return void
     * @throws Exception
     */
    public function testDeleteMovie(): void
    {
        $movieId = static::$fakeDataMovie->createMovie(true);
        $movies = static::$movieRepository->findLastMovie();
        $this->assertNotEmpty($movies, 'No movies found in the repository.');
        static::$commandBus->dispatch(new DeleteMovieCommand($movieId));
    }
}
