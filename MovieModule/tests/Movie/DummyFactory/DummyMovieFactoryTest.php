<?php
declare(strict_types=1);
namespace App\Tests\Movie\DummyFactory;

use App\Movies\Application\DTO\MovieBasicDTO;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use App\Movies\Application\DTO\MovieDetailsParameterDTO;
use App\Movies\Domain\Entity\Movie;

//vendor/bin/phpunit --filter DummyMovieFactoryTest::testCreateMovieMock

/**
 * This class represents unit tests for DummyMovieFactory.
 */
final class DummyMovieFactoryTest extends TestCase
{
    /**
     * Tests correctness of creating DTO object for movie.
     */
    public function testCreateMovieMock(): void
    {
        $faker = Factory::create();
        $movieMock = $this->createMock(Movie::class);

        $movieBasicData = new MovieBasicDTO(
            movieName: $faker->word(),
            description: $faker->sentence(),
            releaseYear: $faker->year(),
            duration: $faker->numberBetween(0, 90),
            ageRestriction: $faker->numberBetween(0, 1500),
            averageRating: $faker->randomFloat()
        );

        $movieDetailsParamData = new MovieDetailsParameterDTO(
            productionCountry: [$faker->country()],
            directors: [$faker->name()],
            actors: [$faker->name()],
            category: [$faker->word()],
            tags: [$faker->word()],
            languages: [$faker->locale()],
            subtitles: [$faker->word()]
        );

        $this->setUpValueObject($movieMock, $movieBasicData);
        $this->setUpValueObject($movieMock, $movieDetailsParamData);
    }

    /**
     * Sets the generated data on mock object for DTO.
     *
     * @param mixed $mock      Mock object.
     * @param mixed $data      Data to set.
     */
    private function setUpValueObject(mixed $mock, mixed $data): void
    {
        foreach ($data as $method => $value) {
            $this->setUpValueObjectMethod($mock, $method, $value);
        }
    }

    /**
     * Sets the generated data using a specific method on mock object for DTO.
     *
     * @param mixed $mock      Mock object.
     * @param string $method   Method name to set value.
     * @param mixed $value     Value to set.
     */
    private function setUpValueObjectMethod(mixed $mock, string $method, mixed $value): void
    {
        $mock->expects($this->once())
            ->method($method)
            ->willReturn($value);
    }
}
