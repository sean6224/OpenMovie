<?php
declare(strict_types=1);
namespace App\Ratings\Application\UseCase\Command\DeleteRating;

use App\Common\Application\Command\CommandHandler;
use App\Common\Domain\ValueObject\Id;
use App\Ratings\Application\Service\DeleteRating;

readonly class DeleteRatingCommandHandler implements CommandHandler
{
    /**
     * Constructs new DeleteRatingCommandHandler instance.
     *
     * @param DeleteRating $deleteRating The service responsible for deleting rating.
     */
    public function __construct(
        private DeleteRating $deleteRating
    ) {
    }


    /**
     * Handles the DeleteMovieCommand.
     *
     * @param DeleteRatingCommand $command The command to delete rating.
     * @return void
     */
    public function __invoke(DeleteRatingCommand $command): void
    {
        $this->deleteRating->deleteMovie(
            Id::fromString($command->ratingId)
        );
    }
}
