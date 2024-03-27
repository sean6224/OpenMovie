<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use App\Common\Application\Command\CommandBus;
use App\Movies\Application\UseCase\Command\UpdateMovie\UpdateMovieCommand;
use App\Tests\Movie\DummyFactory\DummyMovieFactory;
use App\Movies\Domain\Repository\MovieRepository;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UpdateMovieTest extends KernelTestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    /**
     * @throws Exception
     */
    public function testUpdateMovie(): void
    {
        $movieRepository = static::getContainer()->get(MovieRepository::class);
        $commandBus = static::getContainer()->get(CommandBus::class);

        $createdMovie = DummyMovieFactory::createMovie();
        $movieRepository->add($createdMovie);

        $updatedMovieData = DummyMovieFactory::generateMovieBasicData($this->faker);
        $movieDetailsParameters = DummyMovieFactory::generateMovieDetailsParamData($this->faker);
        $movies = $movieRepository->findLastMovie();

        $commandBus->dispatch(
            new UpdateMovieCommand(
                movieId: $movies->id()->value(),
                movieName: $updatedMovieData->movieName,
                description: $updatedMovieData->description,
                releaseYear: $updatedMovieData->releaseYear,
                movieData: $movieDetailsParameters,
                duration: $updatedMovieData->duration,
                ageRestriction: $updatedMovieData->ageRestriction
            )
        );

        $updatedMovie = $movieRepository->get($movies->Id());
        $this->assertEquals($updatedMovieData->movieName, $updatedMovie->getMovieName()->value(), 'Updated movie name is incorrect');
        $this->assertEquals($updatedMovieData->description, $updatedMovie->getDescription()->value(), 'Updated movie description is incorrect');
    }
}
