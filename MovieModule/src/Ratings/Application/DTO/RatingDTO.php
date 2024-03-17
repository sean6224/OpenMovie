<?php
declare(strict_types=1);
namespace App\Ratings\Application\DTO;

/**
 * Represents a Data Transfer Object (DTO) for information of rating.
 */
final readonly class RatingDTO
{
    /**
     * Constructs a new RatingDTO instance.
     *
     * @param string $id The id of Rating.
     * @param string $movieId The uuid movie of movie.
     * @param string $userId The uuid user.
     * @param float $averageRating User evaluation
     */
    public function __construct(
        public string $id,
        public string $movieId,
        public string $userId,
        public float $averageRating
    ) {
    }
}
