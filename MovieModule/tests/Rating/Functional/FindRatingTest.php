<?php
namespace App\Tests\Rating\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Common\Application\Query\QueryBus;
use App\Ratings\Domain\Repository\RatingRepository;
use App\Tests\Rating\DummyFactory\DummyRatingFactory;
use App\Ratings\Application\UseCase\Query\GetRating\GetRatingQuery;
use Exception;


/**
 * Functional tests for finding rating.
 */
class FindRatingTest extends KernelTestCase
{
    /**
     * Test to find rating.
     *
     * @return void
     * @throws Exception
     */
    public function testFindRating(): void
    {
        $ratingRepository = static::getContainer()->get(RatingRepository::class);
        $queryBus = static::getContainer()->get(QueryBus::class);

        $rating = DummyRatingFactory::createRating();
        $ratingRepository->add($rating);
        $retrievedRating = $queryBus->ask(
            new GetRatingQuery(
                $rating->id()->value()
            )
        );

        static::assertSame(
            $rating->id()->value(),
            $retrievedRating->id,
            'Retrieved rating ID does not match expected rating ID'
        );
    }
}
