<?php
declare(strict_types=1);
namespace App\Ratings\Application\UseCase\Query\GetRating;

use App\Common\Application\Query\QueryHandler;
use App\Ratings\Domain\Repository\RatingRepository;
use App\Ratings\Application\DTO\RatingDTO;
use App\Common\Domain\ValueObject\Id;
use App\Ratings\Domain\Exception\RatingNotFound;

/**
 * Query handler for retrieving details of a single rating.
 *
 * This handler is responsible for processing `GetRatingQuery`and fetching details of movie rating from repository based on its unique identifier (ID).
 */
final readonly class GetRatingQueryHandler implements QueryHandler
{
    /**
     * Constructs new GetRatingQueryHandler instance.
     *
     * @param RatingRepository $ratingRepository The repository for accessing rating data.
     */
    public function __construct(
        private RatingRepository $ratingRepository
    ) {
    }
    /**
     * Handles GetRatingQuery to retrieve details of single rating movie.
     *
     * @param GetRatingQuery $query The query object containing rating ID.
     * @return RatingDTO The DTO representing movie rating.
     * @throws RatingNotFound If the requested rating is not found.
     */
    public function __invoke(GetRatingQuery $query): RatingDTO
    {
        $rating = $this->ratingRepository->get(Id::fromString($query->ratingId));
        return RatingDTO::fromEntity($rating);
    }
}
