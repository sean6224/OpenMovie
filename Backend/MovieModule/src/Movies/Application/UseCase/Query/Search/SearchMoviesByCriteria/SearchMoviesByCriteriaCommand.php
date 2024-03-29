<?php

namespace App\Movies\Application\UseCase\Query\Search\SearchMoviesByCriteria;

use App\Common\Application\Command\Command;

final class SearchMoviesByCriteriaCommand implements Command
{
    public function __construct(
        public array $filters,
        public string $sort,
        public string $order,
        public int $page,
        public int $pageSize
    ) {
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getSort(): string
    {
        return $this->sort;
    }

    public function getOrder(): string
    {
        return $this->order;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }
}
