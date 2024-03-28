<?php
namespace App\Tests\Rating\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Common\Application\Command\CommandBus;
use App\Ratings\Domain\Repository\RatingRepository;
use App\Tests\Rating\DummyFactory\DummyRatingFactory;
use App\Ratings\Application\UseCase\Command\UpdateRatingMovie\UpdateRatingMovieCommand;
use Exception;

class UpdateRatingTest extends KernelTestCase
{
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
                ratingId: $rating->id()->value(),
                movieId: $rating->movieId()->value(),
                userId: $rating->userId()->value(),
                averageRating: $rating->averageRating()->value(),
            )
        );

        $updatedRating = $ratingRepository->get($rating->id());
        $this->assertEquals($rating->averageRating()->value(), $updatedRating->averageRating()->value(), 'Updated movie average rating is incorrect');
    }
}
