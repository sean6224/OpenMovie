<?php
namespace App\Tests\Rating\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Common\Application\Command\CommandBus;
use App\Ratings\Domain\Repository\RatingRepository;
use App\Tests\Rating\DummyFactory\DummyRatingFactory;
use App\Ratings\Application\UseCase\Command\UpdateRatingMovie\UpdateRatingMovieCommand;
use Faker\Factory;
use Faker\Generator;
use Exception;

class UpdateRatingTest extends KernelTestCase
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
    public function testUpdateRating(): void
    {
        $ratingRepository = static::getContainer()->get(RatingRepository::class);
        $commandBus = static::getContainer()->get(CommandBus::class);

        $createdRating = DummyRatingFactory::createRating();
        $ratingRepository->add($createdRating);

        $rating = $ratingRepository->findLastRating();
        $commandBus->dispatch(
            new UpdateRatingMovieCommand(
                ratingId: $rating->id(),
                movieId: $this->faker->uuid(),
                userId: $this->faker->uuid(),
                averageRating: $this->faker->randomFloat(1, 1, 10)
            )
        );

        $updatedRating = $ratingRepository->get($rating->id());
        $this->assertEquals($rating->averageRating()->value(), $updatedRating->averageRating()->value(), 'Updated movie average rating is incorrect');
    }
}
