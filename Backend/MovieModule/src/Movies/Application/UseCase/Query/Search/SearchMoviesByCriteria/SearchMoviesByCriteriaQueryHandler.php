<?php
declare(strict_types=1);
namespace App\Movies\Application\UseCase\Query\Search\SearchMoviesByCriteria;

use App\Common\Application\Query\QueryHandler;
use App\Movies\Domain\Repository\MovieRepository;
use App\Movies\Application\DTO\MovieDTO;
use App\Movies\Domain\Entity\Movie;

final readonly class SearchMoviesByCriteriaQueryHandler implements QueryHandler
{
    /**
     * Constructs new SearchMoviesByCriteriaQueryHandler instance.
     *
     * @param MovieRepository $movieRepository The movie repository used for accessing movie data.
     */
    public function __construct(
        private MovieRepository $movieRepository,
    ) {
    }

    public function __invoke(SearchMoviesByCriteriaQuery $query): array
    {
        $movies = $this->movieRepository->searchByCriteria(
            $query->getFilters(),
            $query->getSort(),
            $query->getOrder(),
            $query->getPage(),
            $query->getPageSize()
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
