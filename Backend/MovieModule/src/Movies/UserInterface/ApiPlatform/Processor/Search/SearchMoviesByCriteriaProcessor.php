<?php
declare(strict_types=1);
namespace App\Movies\UserInterface\ApiPlatform\Processor\Search;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Query\QueryBus;
use App\Movies\Application\DTO\MovieDTO;
use App\Movies\Domain\Exception\MissingOrEmptyAttributesException;
use App\Movies\Application\UseCase\Query\Search\SearchMoviesByCriteria\SearchMoviesByCriteriaQuery;
use App\Movies\UserInterface\ApiPlatform\Output\MovieSearchOutput;
use App\Movies\UserInterface\ApiPlatform\Resource\MovieResource;

/**
 * The SearchMoviesByCriteriaProcessor is responsible for processing input data
 * and creating new search resource in system.
 *
 * @package App\Movies\UserInterface\ApiPlatform\Processor
 */
final readonly class SearchMoviesByCriteriaProcessor implements ProcessorInterface
{
    /**
     * Creates new instance of SearchMoviesByCriteriaProcessor.
     *
     * @param QueryBus $queryBus
     */
    public function __construct(
        private QueryBus   $queryBus,
    ) {
    }

    /**
     * Processes the input data to perform movie search operation.
     *
     * @param mixed $data Input data for movie search operation.
     * @param Operation $operation Metadata about the processing operation.
     * @param array $uriVariables Variables extracted from URI.
     * @param array $context Additional context for processing.
     * @return MovieSearchOutput The array representing search results.
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): MovieSearchOutput
    {
        $this->validate($data);

        $movies = $this->queryBus->ask(
            new SearchMoviesByCriteriaQuery(
                filters: $data->getFilters(),
                sort: $data->getSort(),
                order: $data->getOrder(),
                page: $data->getPage(),
                pageSize: $data->getPageSize()
            )
        );
        $movieResources = $this->mapMovieDTOsToMovieResources($movies);
        return new MovieSearchOutput($movieResources);
    }

    /**
     * Validates the provided data to ensure required attributes are not missing or empty.
     *
     * @param mixed $data The data to validate.
     * @throws MissingOrEmptyAttributesException Thrown when required attributes are missing or empty.
     */
    private function validate(mixed $data): void
    {
        $requiredAttributes = [
            'productionCountry' => false,
            'category' => false,
            'languages' => false,
            'subtitles' => false
        ];

        foreach ($requiredAttributes as $attribute => $isRequired) {
            if (!isset($data->filters[$attribute]) || empty(array_filter($data->filters[$attribute]))) {
                $missingAttributes[] = $attribute;
            }
        }

        if (!empty($missingAttributes)) {
            throw new MissingOrEmptyAttributesException($missingAttributes);
        }
    }


    /**
     * Maps movie DTOs to movie resources.
     *
     * @param MovieDTO[] $movieDTOs The movie DTOs to map
     * @return MovieResource[] The mapped movie resources
     */
    private function mapMovieDTOsToMovieResources(array $movieDTOs): array
    {
        $searchResources = [];
        foreach ($movieDTOs as $movieDTO) {
            $searchResources[] = MovieResource::fromMovieDTO($movieDTO);
        }
        return $searchResources;
    }
}
