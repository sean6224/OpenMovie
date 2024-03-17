<?php
declare(strict_types=1);
namespace App\Ratings\UserInterface\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\CommandBus;
use App\Ratings\Application\UseCase\Command\CreateRating\CreateRatingCommand;
use App\Ratings\UserInterface\ApiPlatform\Resource\RatingResource;

/**
 * The CreateRatingProcessor is responsible for processing input data
 * and creating a new movie resource in the system.
 *
 * @package App\Movies\UserInterface\ApiPlatform\Processor
 */
final readonly class CreateRatingProcessor implements ProcessorInterface
{
    /**
     * Creates a new instance of CreateRatingProcessor.
     *
     * @param CommandBus $commandBus The CommandBus object to handle the create movie command.
     */
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    /**
     * The process method processes the input data and creates a new rating resource based on that data.
     *
     * @param mixed $data The input data needed to create the rating.
     * @param Operation $operation The object representing the processing operation.
     * @param array $uriVariables The URI variables.
     * @param array $context The processing context.
     * @return RatingResource The rating resource created based on the input data.
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): RatingResource
    {
        print_r($data);
        $ratingDTO = new CreateRatingCommand(
            movieId: $data->movieId,
            userId: $data->userId,
            averageRating: $data->averageRating
        );
        return RatingResource::fromRatingDTO(
            $this->commandBus->dispatch($ratingDTO)
        );
    }
}
