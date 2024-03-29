<?php
declare(strict_types=1);
namespace App\Ratings\Application\UseCase\Command\DeleteRating;

use App\Common\Application\Command\Command;

final readonly class DeleteRatingCommand implements Command
{
    /**
     * Constructs new DeleteRatingCommand instance.
     *
     * @param string $ratingId The ID of rating to delete.
     */
    public function __construct(
        public string $ratingId,
    ) {
    }
}
