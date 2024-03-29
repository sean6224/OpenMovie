<?php
declare(strict_types=1);
namespace App\Movies\UserInterface\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Movies\UserInterface\ApiPlatform\Processor\Search\SearchMoviesByCriteriaProcessor;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    shortName: 'Search',
    operations: [
        new Post(
            '/movies/search/by/owner',
            openapiContext: [
                'summary' => 'Search for movies based on own criteria.',
                "requestBody" => [
                    "description" => "Allows to search for movies using customized criteria tailored to your needs.",
                    "content" => [
                        "application/json" => [
                            "example" => [
                                "filters" => [
                                    "productionCountry" => [""],
                                    "directors" => [""],
                                    "actors" => [""],
                                    "category" => [""],
                                    "languages" => [""],
                                    "subtitles" => [""],
                                    "min-duration" => 10,
                                    "max-duration" => 60,
                                    "ageRestriction" => 16,
                                    "averageRating" => 1.0
                                ],
                                "sort" => "releaseDate",
                                "order" => "desc",
                                "page" => 1,
                                "pageSize" => 10
                            ],
                            "schema" => [
                                "type" => "object",
                                "properties" => [
                                    "filters" => [
                                        "type" => "object",
                                        "properties" => [
                                            "duration" => ["type" => "integer"],
                                            "ageRestriction" => ["type" => "integer"],
                                            "averageRating" => ["type" => "float"]
                                        ],
                                        "required" => ["duration", "ageRestriction", "averageRating"]
                                    ],
                                    "sort" => ["type" => "string"],
                                    "order" => ["type" => "string"],
                                    "page" => ["type" => "integer"],
                                    "pageSize" => ["type" => "integer"]
                                ],
                                "required" => ["sort", "order", "page", "pageSize"]
                            ]
                        ]
                    ]
                ],
            ],
            denormalizationContext: ['groups' => ['create']],
            validationContext: ['groups' => ['create']],
            processor: SearchMoviesByCriteriaProcessor::class
        ),
    ]
)]

class SearchResource
{
    /**
     * Constructs new instance of class.
     *
     * @param array $filters An array containing filters.
     * @param string $sort A string representing the sort method.
     * @param string $order A string representing the sort order.
     * @param int $page The page number.
     * @param int $pageSize The page size.
     */
    public function __construct(
        /**
         * @Groups({"read", "create"})
         */
        public array $filters = [],
        /**
         * @Groups({"read", "create"})
         */
        public string $sort = '',
        /**
         * @Groups({"read", "create"})
         */
        public string $order = '',
        /**
         * @Groups({"read", "create"})
         */
        public int $page = 1,
        /**
         * @Groups({"read", "create"})
         */
        public int $pageSize = 10,
    ) {}

    /**
     * Get the filters for the query.
     *
     * @return array An array containing filters.
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * Get the sort method.
     *
     * @return string A string representing the sort method.
     */
    public function getSort(): string
    {
        return $this->sort;
    }

    /**
     * Get the sort order (ascending/descending).
     *
     * @return string A string representing the sort order.
     */
    public function getOrder(): string
    {
        return $this->order;
    }

    /**
     * Get the page number.
     *
     * @return int The page number.
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * Get the page size.
     *
     * @return int The page size.
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }
}
