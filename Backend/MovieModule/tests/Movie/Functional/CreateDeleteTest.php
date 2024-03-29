<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Tests\Movie\DummyFactory\DummyMovieFactory;
use App\Movies\Application\UseCase\Command\DeleteMovie\DeleteMovieCommand;
use App\Common\Application\Command\CommandBus;
use App\Movies\Domain\Repository\MovieRepository;
use Exception;


/**
 * Functional test case for creating and deleting movies.
 */
class CreateDeleteTest extends KernelTestCase
{
    /**
     * Test for deleting movie.
     *
     * @return void
     * @throws Exception
     */
    public function testDeleteMovie(): void
    {
        $movieRepository = static::getContainer()->get(MovieRepository::class);
        $commandBus = static::getContainer()->get(CommandBus::class);

        $movies = DummyMovieFactory::createMovie();
        $commandBus->dispatch(new DeleteMovieCommand($movies->id()->value()));
        $this->assertNotEmpty($movies, 'No movies found in the repository.');
    }
}
