<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use App\Tests\Movie\DummyFactory\DummyMovieFactory;
use App\Common\Domain\ValueObject\Id;
use App\Movies\Application\DTO\MovieBasicDTO;
use App\Movies\Domain\Entity\Movie;
use App\Movies\Domain\Repository\MovieRepository;
use App\Movies\Domain\ValueObject\AgeRestriction;
use App\Movies\Domain\ValueObject\Description;
use App\Movies\Domain\ValueObject\Duration;
use App\Movies\Domain\ValueObject\MovieName;
use App\Movies\Domain\ValueObject\ReleaseYear;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UpdateMovieTest extends KernelTestCase
{
    private static MovieRepository $movieRepository;
    private Generator $faker;
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
    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }
    public function testUpdateMovie(): void
    {
        $createdMovie = DummyMovieFactory::createMovie();
        static::$movieRepository->add($createdMovie);

        $updatedMovieData = DummyMovieFactory::generateMovieBasicData($this->faker);
        $this->updateMovie($createdMovie, $updatedMovieData);

        $updatedMovie = static::$movieRepository->get(Id::fromString($createdMovie->id()->value()));
        $this->assertEquals($updatedMovieData->movieName, $updatedMovie->getMovieName()->value(), 'Updated movie name is incorrect');
        $this->assertEquals($updatedMovieData->description, $updatedMovie->getDescription()->value(), 'Updated movie description is incorrect');
    }

    /**
     * Updates an existing movie entity with new data.
     *
     * @param Movie         $movie       The movie entity to be updated.
     * @param MovieBasicDTO $updateData  The new data for the movie entity.
     * @return void
     */
    private function updateMovie(Movie $movie, MovieBasicDTO $updateData): void
    {
        $movieDetailsParameters = DummyMovieFactory::generateMovieDetailsParamData($this->faker);

        $movie->update(
            MovieName::fromString($updateData->movieName),
            Description::fromString($updateData->description),
            ReleaseYear::fromString($updateData->releaseYear),
            $movieDetailsParameters->toArray(),
            Duration::fromInt($updateData->duration),
            AgeRestriction::fromInt($updateData->ageRestriction)
        );
    }
}
