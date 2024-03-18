<?php
declare(strict_types=1);
namespace App\Ratings\UserInterface\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Common\Application\Query\QueryBus;
use App\Ratings\Application\DTO\RatingDTO;
use App\Ratings\Application\UseCase\Query\GetRating\GetRatingQuery;
use App\Ratings\UserInterface\ApiPlatform\Resource\RatingResource;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Provider for fetching a single rating resource.
 *
 * This provider retrieves information about a single rating based on its unique identifier (ID).
 */
final readonly class SingleRatingProvider implements ProviderInterface
{
    /**
     * Constructs a new SingleRatingProvider instance.
     *
     * @param QueryBus $queryBus The query bus for executing queries.
     */
    public function __construct(
        private QueryBus $queryBus
    ) {
    }

    /**
     * Provides single rating resource based on given operation and URI variables.
     *
     * @param Operation $operation The operation metadata.
     * @param array $uriVariables The URI variables.
     * @param array $context Additional context options.
     * @return RatingResource The rating resource.
     *
     * @throws HttpException If an error occurs while retrieving rating resource.
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): RatingResource
    {
        try {
            $ratingId = (string) $uriVariables['id'];
            $ratingDTO = $this->getRatingById($ratingId);
        } catch (InvalidArgumentException $exception) {
            throw new HttpException(400, $exception->getMessage());
        }

        return RatingResource::fromRatingDTO($ratingDTO);
    }


    /**
     * Retrieves rating DTO by its ID.
     *
     * @param string $ratingId The ID rating.
     * @return RatingDTO The rating DTO.
     */
    private function getRatingById(string $ratingId): RatingDTO
    {
        return $this->queryBus->ask(new GetRatingQuery(ratingId: $ratingId));
    }
}
