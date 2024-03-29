<?php
declare(strict_types=1);
namespace App\Movies\UserInterface\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Common\Application\Query\QueryBus;
use App\Movies\UserInterface\ApiPlatform\Resource\MovieResource;
use App\Movies\Application\DTO\MovieDTO;
use App\Movies\Application\UseCase\Query\GetMovie\GetMovieQuery;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Provider for fetching a single movie resource.
 *
 * This provider retrieves information about a single movie based on its unique identifier (ID).
 */
final readonly class SingleMovieProvider implements ProviderInterface
{
    /**
     * Constructs a new SingleMovieProvider instance.
     *
     * @param QueryBus $queryBus The query bus for executing queries.
     */
    public function __construct(
        private QueryBus $queryBus
    ){
    }

    /**
     * Provides a single movie resource based on the given operation and URI variables.
     *
     * @param Operation $operation The operation metadata.
     * @param array $uriVariables The URI variables.
     * @param array $context Additional context options.
     * @return MovieResource The movie resource.
     *
     * @throws HttpException If an error occurs while retrieving the movie resource.
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): MovieResource
    {
        try {
            $movieId = (string) $uriVariables['id'];
            $movieDTO = $this->getMovieById($movieId);
        } catch (InvalidArgumentException $exception) {
            throw new HttpException(400, $exception->getMessage());
        }

        return MovieResource::fromMovieDTO($movieDTO);
    }

    /**
     * Retrieves a movie DTO by its ID.
     *
     * @param string $movieId The ID of the movie.
     * @return MovieDTO The movie DTO.
     */
    private function getMovieById(string $movieId): MovieDTO
    {
        return $this->queryBus->ask(new GetMovieQuery(movieId: $movieId));
    }
}
