<?php
declare(strict_types=1);
namespace App\Ratings\Application\UseCase\Command\CreateRating;

use App\Common\Application\Command\Command;
use App\Ratings\Application\DTO\RatingDTO;

/**
 * Represents a command for creating rating.
 */
final class CreateRatingCommand implements Command
{
    /**
     * Constructs a new CreateRatingCommand instance.
     *
     * @param string $movieId The ID of movie.
     * @param string $userId The ID of user.
     * @param float $averageRating The average rating of movie.
     */
    public function __construct(
        public string $movieId,
        public string $userId,
        public float $averageRating
    ) {
    }

    /**
     * Converts the current object toRatingDTO object.
     *
     * @return RatingDTO Returns new instance of RatingDTO.
     */
    public function toDto(): RatingDTO
    {
        return new RatingDTO(
            id: '',
            movieId: $this->movieId,
            userId: $this->userId,
            averageRating: $this->averageRating
        );
    }
}
