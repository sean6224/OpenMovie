<?php
namespace App\Tests\Rating\Functional;

use App\Tests\Rating\DummyFactory\DummyRatingFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Ratings\Domain\Repository\RatingRepository;
use App\Common\Application\Command\CommandBus;
use App\Ratings\Application\UseCase\Command\DeleteRating\DeleteRatingCommand;
use Exception;

class DeleteRatingTest extends KernelTestCase
{
    /**
     * Test for deleting rating.
     *
     * @return void
     * @throws Exception
     */
    public function testDeleteRating(): void
    {
        $ratingRepository = static::getContainer()->get(RatingRepository::class);
        $commandBus = static::getContainer()->get(CommandBus::class);

        $rating = DummyRatingFactory::createRating();
        $ratingRepository->add($rating);
        $commandBus->dispatch(new DeleteRatingCommand($rating->id()->value()));
        $this->assertNotEmpty($rating, 'No rating found in repository.');
    }
}
