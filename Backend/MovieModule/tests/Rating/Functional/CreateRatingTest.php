<?php
namespace App\Tests\Rating\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Common\Application\Command\CommandBus;
use App\Ratings\Domain\Repository\RatingRepository;
use App\Ratings\Application\UseCase\Command\CreateRating\CreateRatingCommand;
use App\Ratings\Domain\Entity\Rating;
use Faker\Factory;
use Faker\Generator;
use Exception;

class CreateRatingTest extends KernelTestCase
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
    public function testCreateRating(): void
    {
        $ratingRepository = static::getContainer()->get(RatingRepository::class);
        $commandBus = static::getContainer()->get(CommandBus::class);

        $value = $this->faker->randomFloat(null, 1, 5);
        $roundedValue = round($value, 1);

        $commandBus->dispatch(
            new CreateRatingCommand(
                movieId: $this->faker->uuid(),
                userId: $this->faker->uuid(),
                averageRating: $roundedValue
            )
        );
        $rating = $ratingRepository->findLastRating();
        $this->assertNotEmpty($rating, 'No rating found in repository.');
        $this->assertInstanceOf(Rating::class, $rating, 'Failed to fetch rating from repository.');
    }
}
