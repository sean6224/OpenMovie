<?php
declare(strict_types=1);
namespace App\Movies\UserInterface\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\CommandBus;
use App\Movies\Application\UseCase\Command\CreateMovie\CreateMovieCommand;
use App\Movies\UserInterface\ApiPlatform\Resource\MovieResource;

/**
 * The CreateMovieProcessor is responsible for processing input data
 * and creating a new movie resource in the system.
 *
 * @package App\Movies\UserInterface\ApiPlatform\Processor
 */
final readonly class CreateMovieProcessor implements ProcessorInterface
{
    /**
     * Creates a new instance of CreateMovieProcessor.
     *
     * @param CommandBus $commandBus The CommandBus object to handle the create movie command.
     */
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    /**
     * The process method processes the input data and creates a new movie resource based on that data.
     *
     * @param mixed     $data          The input data needed to create the movie.
     * @param Operation $operation     The object representing the processing operation.
     * @param array     $uriVariables  The URI variables.
     * @param array     $context       The processing context.
     * @return MovieResource            The movie resource created based on the input data.
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): MovieResource
    {
        $movieDTO = new CreateMovieCommand(
            movieBasicDTO: $data->movieBasic,
            movieDetailsDTO: $data->movieDetailsParameters,
        );

        return MovieResource::fromMovieDTO(
            $this->commandBus->dispatch($movieDTO)
        );
    }
}
