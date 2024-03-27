<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use App\Movies\Application\Service\DeleteMovie;
use App\Tests\Movie\DummyFactory\DummyMovieFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Common\Application\Command\CommandBus;
use App\Movies\Domain\Repository\MovieRepository;
use Exception;

/**
 * Functional test case for creating and deleting movies.
 */
class CreateDeleteTest extends KernelTestCase
{
    private static CommandBus $commandBus;
    private static MovieRepository $movieRepository;
    private static DeleteMovie $deleteMovie;
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
        static::$deleteMovie = static::getContainer()->get(DeleteMovie::class);
    }

    /**
     * Test for deleting movie.
     *
     * @return void
     * @throws Exception
     */
    public function testDeleteMovie(): void
    {
        DummyMovieFactory::createMovie();
        $movies = static::$movieRepository->findLastMovie();
        $this->assertNotEmpty($movies, 'No movies found in the repository.');
        static::$deleteMovie->deleteMovie($movies->id());

    }
}
