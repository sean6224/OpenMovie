<?php
declare(strict_types=1);
namespace App\Movies\UserInterface\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\CommandBus;
use App\Movies\Application\UseCase\Command\UpdateMovie\UpdateMovieCommand;
use App\Movies\UserInterface\ApiPlatform\Resource\MovieResource;

/**
 * The PatchMovieProcessor is responsible for processing input data
 * and updating an existing movie resource in the system.
 *
 * @package App\Movies\UserInterface\ApiPlatform\Processor
 */
final readonly class PatchMovieProcessor implements ProcessorInterface
{
    /**
     * Creates a new instance of PatchMovieProcessor.
     *
     * @param CommandBus $commandBus The CommandBus object to handle the update movie command.
     */
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    /**
     * The process method processes the input data and updates an existing movie resource based on that data.
     *
     * @param mixed     $data          The input data needed to update the movie.
     * @param Operation $operation     The object representing the processing operation.
     * @param array     $uriVariables  The URI variables.
     * @param array     $context       The processing context.
     * @return MovieResource            The movie resource updated based on the input data.
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): MovieResource
    {
        $movieDTO = new UpdateMovieCommand(
            movieId: $uriVariables['id'],
            movieBasicDTO: $data->movieBasic,
            movieDetailsDTO: $data->movieDetailsParameters,
        );
        $updatedMovie = $this->commandBus->dispatch($movieDTO);
        return MovieResource::fromMovieDTO($updatedMovie);
    }
}
