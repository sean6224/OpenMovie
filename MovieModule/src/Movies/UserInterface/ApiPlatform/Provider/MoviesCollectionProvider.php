<?php
declare(strict_types=1);
namespace App\Movies\UserInterface\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\ProviderInterface;
use App\Common\Application\Query\QueryBus;

use App\Movies\Application\DTO\MovieDTO;
use App\Movies\Application\UseCase\Query\SearchMoviesPaginatedQuery\SearchMoviesPaginatedQuery;
use App\Movies\UserInterface\ApiPlatform\Resource\MovieResource;

/**
 * Implements the ProviderInterface for MovieResource.
 *
 * This class is responsible for providing movie resources for API operations.
 *
 * @implements ProviderInterface<MovieResource>
 */
final readonly class MoviesCollectionProvider implements ProviderInterface
{
    /**
     * Constructs a new MoviesCollectionProvider instance.
     *
     * @param QueryBus $queryBus The query bus to retrieve movie data
     * @param Pagination $pagination The pagination service for handling page and limit
     */
    public function __construct(
        private QueryBus   $queryBus,
        private Pagination $pagination,
    ) {
    }

    /**
     * Provides movie resources based on the specified operation and context.
     *
     * @param Operation $operation The API operation
     * @param array $uriVariables The URI variables
     * @param array $context The context options
     * @return MovieResource[] The provided movie resources
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $page = $this->pagination->getPage($context);
        $itemsPerPage = $this->pagination->getLimit($operation, $context);

        $movies = $this->getMoviesDTOs($page, $itemsPerPage);
        return $this->mapMovieDTOsToMovieResources($movies);
    }

    /**
     * Retrieves movie DTOs based on the specified page and items per page.
     *
     * @param int $page The page number
     * @param int $itemsPerPage The number of items per page
     * @return MovieDTO[] The retrieved movie DTOs
     */
    private function getMoviesDTOs(int $page, int $itemsPerPage): array
    {
        return $this->queryBus->ask(new SearchMoviesPaginatedQuery($page, $itemsPerPage));
    }

    /**
     * Maps movie DTOs to movie resources.
     *
     * @param MovieDTO[] $movieDTOs The movie DTOs to map
     * @return MovieResource[] The mapped movie resources
     */
    private function mapMovieDTOsToMovieResources(array $movieDTOs): array
    {
        $movieResources = [];
        foreach ($movieDTOs as $movieDTO) {
            $movieResources[] = MovieResource::fromMovieDTO($movieDTO);
        }
        return $movieResources;
    }
}
