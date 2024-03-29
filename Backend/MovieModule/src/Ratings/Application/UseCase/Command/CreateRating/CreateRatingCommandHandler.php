<?php
declare(strict_types=1);
namespace App\Ratings\Application\UseCase\Command\CreateRating;

use App\Common\Application\Command\CommandHandler;
use App\Ratings\Application\Service\RatingCreator;
use App\Ratings\Application\DTO\RatingDTO;

/**
 * Command handler for creating a rating.
 */
final readonly class CreateRatingCommandHandler implements CommandHandler
{
    /**
     * Constructs new CreateRatingCommandHandler instance.
     *
     * @param RatingCreator $ratingCreator The rating creator service.
     */
    public function __construct(
        private RatingCreator $ratingCreator,
    ) {
    }

    /**
     * Handles the CreateRatingCommand to create new rating.
     *
     * @param CreateRatingCommand $command The command object containing rating information.
     * @return RatingDTO Returns the DTO representation of created rating.
     */
    public function __invoke(CreateRatingCommand $command): RatingDTO
    {
        return RatingDTO::fromEntity(
            $this->ratingCreator->createRating($command->toDto())
        );
    }
}
