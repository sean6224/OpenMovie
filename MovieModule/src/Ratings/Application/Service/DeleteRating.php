<?php
declare(strict_types=1);
namespace App\Ratings\Application\Service;

use App\Common\Domain\ValueObject\Id;
use App\Ratings\Domain\Repository\RatingRepository;

/**
 * Service for deleting Rating entities.
 */
final readonly class DeleteRating
{
    /**
     * DeleteRating constructor.
     *
     * @param RatingRepository $ratingRepository The repository for accessing rating data.
     */
    public function __construct(
        private RatingRepository $ratingRepository,
    ) {
    }

    /**
     * Deletes Rating entity.
     *
     * @param Id $ratingId The ID of rating to be deleted.
     */
    public function deleteRating(
        Id $ratingId
    ): void
    {
        $rating = $this->ratingRepository->get($ratingId);
        $this->ratingRepository->remove($rating);
    }
}
