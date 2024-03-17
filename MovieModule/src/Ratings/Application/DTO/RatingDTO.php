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
     * @param string $movieId The uuid of movie.
     * @param float $averageRating User evaluation
     */
    public function __construct(
        public string $id,
        public string $movieId,
        public float $averageRating
    ) {
    }
}
