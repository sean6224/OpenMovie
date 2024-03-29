<?php
declare(strict_types=1);
namespace App\Movies\UserInterface\ApiPlatform\Processor\Search;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\CommandBus;
use App\Movies\Application\UseCase\Query\Search\SearchMoviesByCriteria\SearchMoviesByCriteriaCommand;
use App\Movies\UserInterface\ApiPlatform\Resource\SearchResource;

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
     * @param CommandBus $commandBus The CommandBus object to handle search command.
     */
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    /**
     * Processes the input data to perform movie search operation.
     *
     * @param mixed     $data          Input data for movie search operation.
     * @param Operation $operation     Metadata about the processing operation.
     * @param array     $uriVariables  Variables extracted from URI.
     * @param array     $context       Additional context for processing.
     * @return SearchResource          The resource representing search results.
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): SearchResource
    {
        return $this->commandBus->dispatch(
            new SearchMoviesByCriteriaCommand(
                filters: $data->getFilters(),
                sort: $data->getSort(),
                order: $data->getOrder(),
                page: $data->getPage(),
                pageSize: $data->getPageSize()
            )
        );
    }
}
