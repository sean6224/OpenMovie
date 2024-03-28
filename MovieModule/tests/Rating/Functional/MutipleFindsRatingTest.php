<?php
namespace App\Tests\Rating\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Ratings\Domain\Repository\RatingRepository;
use App\Common\Application\Query\QueryBus;
use App\Tests\Rating\DummyFactory\DummyRatingFactory;
use App\Ratings\Application\UseCase\Query\SearchRatingsPaginated\SearchRatingsPaginatedQuery;
use Exception;

/**
 * Functional tests for finding multiple ratings.
 */
class MutipleFindsRatingTest extends KernelTestCase
{
    /**
     * @throws Exception
     */
    public function testFindRatings(): void
    {
        $ratingRepository = static::getContainer()->get(RatingRepository::class);
        $queryBus = static::getContainer()->get(QueryBus::class);

        $initialRating = array_map(static function () {
            return DummyRatingFactory::createRating();
        }, range(1, 3));

        foreach ($initialRating as $rating) {
            $ratingRepository->add($rating);
        }

        $ratings = $queryBus->ask(
            new SearchRatingsPaginatedQuery(1, 3)
        );

        static::assertCount(count($initialRating), $ratings);
    }
}
