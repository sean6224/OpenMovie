<?php
declare(strict_types=1);
namespace App\Movies\Application\UseCase\Query\SearchMoviesPaginatedQuery;

use App\Common\Application\Query\Query;

/**
 * Represents a query for searching movies in a paginated manner.
 *
 * This class encapsulates the parameters for paginated movie search, including the page number, the number of items per page, sorting by field, and sort order.
 */
final readonly class SearchMoviesPaginatedQuery implements Query
{
    /**
     * Constructs a new SearchMoviesPaginatedQuery instance.
     *
     * @param int $page The page number for pagination (default is 1).
     * @param int $itemsPerPage The number of items per page (default is 20).
     * @param string $sortBy The field to sort the results by.
     * @param string $sortOrder The sorting order ('asc' or 'desc').
     */
    public function __construct(
        public int $page = 1,
        public int $itemsPerPage = 20,
        public string $sortBy = 'releaseYear', // Default sort by releaseYear
        public string $sortOrder = 'asc' // Default sort order ascending
    ) {
    }

    /**
     * Gets the page number for pagination.
     *
     * @return int The page number.
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * Gets the number of items per page.
     *
     * @return int The number of items per page.
     */
    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    /**
     * Gets the field to sort the results by.
     *
     * @return string The field to sort by.
     */
    public function getSortBy(): string
    {
        return $this->sortBy;
    }

    /**
     * Gets the sorting order ('asc' or 'desc').
     *
     * @return string The sorting order.
     */
    public function getSortOrder(): string
    {
        return $this->sortOrder;
    }
}
