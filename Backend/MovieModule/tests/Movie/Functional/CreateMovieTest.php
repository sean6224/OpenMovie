<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use App\Common\Application\Command\CommandBus;
use App\Movies\Application\UseCase\Command\CreateMovie\CreateMovieCommand;
use App\Movies\Domain\Repository\MovieRepository;
use App\Movies\Domain\Entity\Movie;
use App\Tests\Movie\DummyFactory\DummyMovieFactory;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Functional test case for creating movie.
 */
class CreateMovieTest extends KernelTestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    /**
     * Tests the creation of movie.
     *
     * @throws Exception
     */
    public function testCreateMovie(): void
    {
        $movieRepository = static::getContainer()->get(MovieRepository::class);
        $commandBus = static::getContainer()->get(CommandBus::class);

        $movieData = DummyMovieFactory::generateMovieBasicData($this->faker);
        $movieDetailsParameters = DummyMovieFactory::generateMovieDetailsParamData($this->faker);

        $commandBus->dispatch(
            new CreateMovieCommand(
                movieBasicDTO: $movieData,
                movieDetailsDTO: $movieDetailsParameters,
            )
        );

        $movies = $movieRepository->findLastMovie();
        $this->assertNotEmpty($movies, 'No movies found in repository.');
        $this->assertInstanceOf(Movie::class, $movies, 'Failed to fetch movie from repository.');
    }
}
