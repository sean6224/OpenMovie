<?php
declare(strict_types=1);
namespace App\Movies\UserInterface\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\CommandBus;
use App\Movies\Application\UseCase\Command\DeleteMovie\DeleteMovieCommand;

/**
 * The DeleteMovieProcessor is responsible for processing the deletion of a movie resource from the system.
 */
final readonly class DeleteMovieProcessor implements ProcessorInterface
{
    /**
     * Creates a new instance of DeleteMovieProcessor.
     *
     * @param CommandBus $commandBus The CommandBus object to handle the delete movie command.
     */
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    /**
     * The process method processes the deletion of a movie resource based on the provided data.
     *
     * @param mixed     $data          The input data needed to perform the movie deletion.
     * @param Operation $operation     The object representing the processing operation.
     * @param array     $uriVariables  The URI variables.
     * @param array     $context       The processing context.
     * @return void
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $movieId = (string)$uriVariables['id'];
        $this->commandBus->dispatch(
            new DeleteMovieCommand(movieId: $movieId)
        );
    }
}
