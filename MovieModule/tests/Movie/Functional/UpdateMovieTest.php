<?php
declare(strict_types=1);
namespace App\Tests\Movie\Functional;

use App\Common\Domain\ValueObject\Id;
use App\Movies\Application\DTO\MovieBasicDTO;
use App\Movies\Application\DTO\MovieDetailsParameterDTO;
use App\Movies\Domain\Entity\Movie;
use App\Movies\Domain\Repository\MovieRepository;
use App\Movies\Domain\ValueObject\AgeRestriction;
use App\Movies\Domain\ValueObject\AverageRating;
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
        $createdMovie = $this->createMovie();

        $updatedMovieData = $this->generateMovieBasicData();
        $this->updateMovie($createdMovie, $updatedMovieData);

        $updatedMovie = static::$movieRepository->get(Id::fromString($createdMovie->id()->value()));

        $this->assertEquals($updatedMovieData->movieName, $updatedMovie->getMovieName()->value(), 'Updated movie name is incorrect');
        $this->assertEquals($updatedMovieData->description, $updatedMovie->getDescription()->value(), 'Updated movie description is incorrect');
    }

    /**
     * Generates new movie entity with random data.
     *
     * @return Movie
     */
    private function createMovie(): Movie
    {
        $movieBasicData = $this->generateMovieBasicData();
        $movieDetailsParameters = $this->generateMovieDetailsParamData();

        $movie = Movie::create(
            MovieName::fromString($movieBasicData->movieName),
            Description::fromString($movieBasicData->description),
            ReleaseYear::fromString($movieBasicData->releaseYear),
            $movieDetailsParameters->toArray(),
            Duration::fromInt($movieBasicData->duration),
            AgeRestriction::fromInt($movieBasicData->ageRestriction),
            AverageRating::fromFloat($movieBasicData->averageRating),
        );
        static::$movieRepository->add($movie);
        return $movie;
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
        $movieDetailsParameters = $this->generateMovieDetailsParamData();

        $movie->update(
            MovieName::fromString($updateData->movieName),
            Description::fromString($updateData->description),
            ReleaseYear::fromString($updateData->releaseYear),
            $movieDetailsParameters->toArray(),
            Duration::fromInt($updateData->duration),
            AgeRestriction::fromInt($updateData->ageRestriction)
        );
    }

    /**
     * Generates random basic data for movie.
     *
     * @return MovieBasicDTO The generated movie basic data.
     */
    public function generateMovieBasicData(): MovieBasicDTO
    {
        return new MovieBasicDTO(
            movieName: $this->faker->name(),
            description: $this->faker->sentence(),
            releaseYear: $this->faker->year(),
            duration: $this->faker->numberBetween(0, 90),
            ageRestriction: $this->faker->numberBetween(0, 1500),
            averageRating: $this->faker->randomFloat(1, 1, 10)
        );
    }

    /**
     * Generates random details parameter data for movie.
     *
     * @return MovieDetailsParameterDTO The generated movie details parameter data.
     */
    public function generateMovieDetailsParamData(): MovieDetailsParameterDTO
    {
        return new MovieDetailsParameterDTO(
            productionCountry: [$this->faker->country()],
            directors: [$this->faker->name()],
            actors: [$this->faker->name()],
            category: [$this->faker->randomElement(['Action', 'Comedy', 'Drama', 'Thriller'])],
            tags: [$this->faker->randomElement(['Adventure', 'Romance', 'Sci-Fi', 'Horror'])],
            languages: [$this->faker->languageCode()],
            subtitles: [$this->faker->randomElement(['English', 'Spanish', 'French', 'German'])]
        );
    }
}
