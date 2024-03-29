<?php
declare(strict_types=1);
namespace App\Ratings\UserInterface\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Common\Application\Query\QueryBus;
use App\Ratings\Application\DTO\RatingDTO;
use App\Ratings\Application\UseCase\Query\SearchRatingsPaginated\SearchRatingsPaginatedQuery;
use App\Ratings\UserInterface\ApiPlatform\Resource\RatingResource;

/**
 * Implements the ProviderInterface for RatingResource.
 *
 * This class is responsible for providing rating resources for API operations.
 *
 * @implements ProviderInterface<RatingResource>
 */
final readonly class RatingCollectionProvider implements ProviderInterface
{
    /**
     * Constructs new RatingCollectionProvider instance.
     *
     * @param QueryBus $queryBus The query bus to retrieve rating data
     * @param Pagination $pagination The pagination service for handling page and limit
     */
    public function __construct(
        private QueryBus   $queryBus,
        private Pagination $pagination,
    ) {
    }

    /**
     * Provides rating resources based on the specified operation and context.
     *
     * @param Operation $operation The API operation
     * @param array $uriVariables The URI variables
     * @param array $context The context options
     * @return RatingResource[] The provided rating resources
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $page = $this->pagination->getPage($context);
        $itemsPerPage = $this->pagination->getLimit($operation, $context);

        $ratings = $this->getRatingsDTOs($page, $itemsPerPage);
        return $this->mapRatingDTOsToRatingResources($ratings);
    }

    /**
     * Retrieves rating DTOs based on the specified page and items per page.
     *
     * @param int $page The page number
     * @param int $itemsPerPage The number of items per page
     * @return RatingDTO[] The retrieved rating DTOs
     */
    private function getRatingsDTOs(int $page, int $itemsPerPage): array
    {
        return $this->queryBus->ask(new SearchRatingsPaginatedQuery($page, $itemsPerPage));
    }

    /**
     * Maps rating DTOs to rating resources.
     *
     * @param RatingDTO[] $ratingsDTO The rating DTOs to map
     * @return RatingResource[] The mapped rating resources
     */
    private function mapRatingDTOsToRatingResources(array $ratingsDTO): array
    {
        $ratingResources = [];
        foreach ($ratingsDTO as $ratingDTO) {
            $ratingResources[] = RatingResource::fromRatingDTO($ratingDTO);
        }
        return $ratingResources;
    }
}
