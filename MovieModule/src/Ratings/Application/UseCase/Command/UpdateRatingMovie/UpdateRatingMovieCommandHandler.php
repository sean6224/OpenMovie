<?php
declare(strict_types=1);
namespace App\Ratings\Application\UseCase\Command\UpdateRatingMovie;

use App\Common\Application\Command\CommandHandler;
use App\Common\Domain\ValueObject\Id;
use App\Ratings\Domain\Repository\RatingRepository;
use App\Ratings\Domain\ValueObject\AverageRating;
use App\Ratings\Application\DTO\RatingDTO;

/**
 * Command handler responsible for updating rating of movie.
 */
final readonly class UpdateRatingMovieCommandHandler implements CommandHandler
{
    /**
     * Constructs new UpdateRatingMovieCommandHandler instance.
     *
     * @param RatingRepository $ratingRepository The repository for rating entities.
     */
    public function __construct(
        private RatingRepository $ratingRepository
    ) {
    }

    /**
     * Handles the command to update rating of movie.
     *
     * @param UpdateRatingMovieCommand $command The command to update the rating of movie.
     * @return RatingDTO The data transfer object representing updated rating.
     */
    public function __invoke(UpdateRatingMovieCommand $command): RatingDTO
    {
        $rating = $this->ratingRepository->get(Id::fromString($command->ratingId));
        $rating->update(
            AverageRating::fromFloat($command->averageRating)
        );

        return RatingDTO::fromEntity($rating);
    }
}
