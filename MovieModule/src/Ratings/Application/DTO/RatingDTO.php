<?php
declare(strict_types=1);
namespace App\Ratings\Application\DTO;

use App\Ratings\Domain\Entity\Rating;

/**
 * Represents a Data Transfer Object (DTO) for rating information.
 */
final readonly class RatingDTO
{
    /**
     * Constructs a new RatingDTO instance.
     *
     * @param string $id The ID of rating.
     * @param string $movieId The UUID of movie.
     * @param string $userId The UUID of user.
     * @param float $averageRating The average rating.
     */
    public function __construct(
        public string $id,
        public string $movieId,
        public string $userId,
        public float $averageRating
    ) {
    }

    /**
     * Create a RatingDTO from a Rating entity.
     *
     * @param Rating $rating The Rating entity to convert.
     * @return RatingDTO The created RatingDTO.
     */
    public static function fromEntity(Rating $rating): self
    {
        return new self(
            id: (string) $rating->id(),
            movieId: (string) $rating->movieId(),
            userId: (string) $rating->userId(),
            averageRating: $rating->averageRating()->value(),
        );
    }
}
