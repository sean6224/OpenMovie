<?php
declare(strict_types=1);
namespace App\Ratings\Application\UseCase\Command\UpdateRatingMovie;

use App\Common\Application\Command\Command;
use App\Ratings\Application\DTO\RatingDTO;

/**
 * Command object representing request to update rating for movie.
 */
class UpdateRatingMovieCommand implements Command
{
    public function __construct(
        public string $ratingId,
        public string $movieId,
        public string $userId,
        public float $averageRating
    ) {
    }

    /**
     * Converts current object to RatingDTO object.
     *
     * @return RatingDTO Returns new instance of RatingDTO.
     */
    public function toDto(): RatingDTO
    {
        return new RatingDTO(
            id: $this->ratingId,
            movieId: $this->movieId,
            userId: $this->userId,
            averageRating: $this->averageRating,
        );
    }
}
