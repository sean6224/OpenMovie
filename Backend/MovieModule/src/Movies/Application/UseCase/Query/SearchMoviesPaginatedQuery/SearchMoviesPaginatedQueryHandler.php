<?php
declare(strict_types=1);
namespace App\Movies\Application\UseCase\Query\SearchMoviesPaginatedQuery;

use App\Common\Application\Query\QueryHandler;
use App\Movies\Domain\Entity\Movie;
use App\Movies\Application\DTO\MovieDTO;
use App\Movies\Domain\Repository\MovieRepository;

/**
 * Handles the SearchMoviesPaginatedQuery to retrieve paginated movie search results.
 *
 * This class is responsible for handling the SearchMoviesPaginatedQuery by retrieving paginated movie search results
 * based on the provided query parameters.
 */
final readonly class SearchMoviesPaginatedQueryHandler implements QueryHandler
{
    /**
     * Constructs a new SearchMoviesPaginatedQueryHandler instance.
     *
     * @param MovieRepository $movieRepository The movie repository used for accessing movie data.
     */
    public function __construct(
        private MovieRepository $movieRepository,
    ) {
    }

    /**
     * Handles the SearchMoviesPaginatedQuery to retrieve paginated movie search results.
     *
     * @param SearchMoviesPaginatedQuery $query The query object containing search parameters.
     * @return array An array of MovieDTO resources representing the paginated movie search results.
     */
    public function __invoke(SearchMoviesPaginatedQuery $query): array
    {
        $movies = $this->movieRepository->search(
            $query->getPage(),
            $query->getItemsPerPage(),
            $query->getSortBy(),
            $query->getSortOrder()
        );
        return $this->mapToResources($movies);
    }

    /**
     * Maps an array of Movie entities to an array of MovieDTO resources.
     *
     * @param array $movies An array of Movie entities to be mapped.
     * @return array An array of MovieDTO resources representing the mapped movie entities.
     */
    private function mapToResources(array $movies): array
    {
        return array_map(static function (Movie $movie) {
            return MovieDTO::fromEntity($movie);
        }, $movies);
    }
}
