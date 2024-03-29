<?php
declare(strict_types=1);
namespace App\Ratings\UserInterface\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Common\Application\Command\CommandBus;
use App\Ratings\Application\UseCase\Command\UpdateRatingMovie\UpdateRatingMovieCommand;
use App\Ratings\UserInterface\ApiPlatform\Resource\RatingResource;

/**
 * Processor responsible for updating an existing rating resource.
 *
 * This processor processes input data and updates an existing rating resource in system.
 */
final readonly class PatchRatingProcessor implements ProcessorInterface
{
    /**
     * Constructs a new instance of PatchRatingProcessor.
     *
     * @param CommandBus $commandBus The CommandBus object to handle update rating movie command.
     */
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    /**
     * Processes the input data and updates an existing rating for movie resource.
     *
     * @param mixed $data The input data needed to update rating movie.
     * @param Operation $operation The object representing the processing operation.
     * @param array $uriVariables The URI variables.
     * @param array $context The processing context.
     * @return RatingResource The rating resource updated based on input data.
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): RatingResource
    {
        $ratingId = $uriVariables['id'];

        $ratingDTO = new UpdateRatingMovieCommand(
            ratingId: $ratingId,
            movieId: $data->movieId,
            userId: $data->userId,
            averageRating: $data->averageRating,
        );
        $updatedRating = $this->commandBus->dispatch($ratingDTO);
        return RatingResource::fromRatingDTO($updatedRating);
    }
}
