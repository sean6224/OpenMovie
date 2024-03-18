<?php
declare(strict_types=1);
namespace App\Ratings\Application\UseCase\Query\SearchRatingsPaginated;

use App\Common\Application\Query\QueryHandler;
use App\Ratings\Domain\Repository\RatingRepository;
use App\Ratings\Domain\Entity\Rating;
use App\Ratings\Application\DTO\RatingDTO;

/**
 * Handles SearchRatingsPaginatedQuery to retrieve paginated rating search results.
 *
 * This class is responsible for handling SearchRatingsPaginatedQuery by retrieving paginated rating search results
 * based on the provided query parameters.
 */
final readonly class SearchRatingsPaginatedQueryHandler implements QueryHandler
{
    /**
     * Constructs new SearchRatingsPaginatedQueryHandler instance.
     *
     * @param RatingRepository $ratingRepository The rating repository used for accessing rating data.
     */
    public function __construct(
        private RatingRepository $ratingRepository
    ) {
    }

    /**
     * Handles SearchRatingsPaginatedQuery to retrieve paginated rating search results.
     *
     * @param SearchRatingsPaginatedQuery $query The query object containing search parameters.
     * @return array An array of RatingDTO resources representing the paginated rating search results.
     */
    public function __invoke(SearchRatingsPaginatedQuery $query): array
    {
        $ratings = $this->ratingRepository->search(
            $query->getPage(),
            $query->getItemsPerPage(),
            $query->getSortBy(),
            $query->getSortOrder()
        );
        return $this->mapToResources($ratings);
    }

    /**
     * Maps an array of Rating entities to array of RatingDTO resources.
     *
     * @param array $ratings An array of Rating entities to be mapped.
     * @return array An array of RatingDTO resources representing the mapped rating entities.
     */
    private function mapToResources(array $ratings): array
    {
        return array_map(static function (Rating $rating) {
            return RatingDTO::fromEntity($rating);
        }, $ratings);
    }
}
