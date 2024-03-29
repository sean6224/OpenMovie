<?php
declare(strict_types=1);
namespace App\Ratings\Application\Service;

use App\Ratings\Domain\Repository\RatingRepository;
use App\Ratings\Domain\Entity\Rating;
use App\Ratings\Application\DTO\RatingDTO;

use App\Ratings\Domain\Exception\RatingAlreadyExists;
use App\Ratings\Domain\ValueObject\MovieId;
use App\Common\Domain\ValueObject\UserId;
use App\Ratings\Domain\ValueObject\AverageRating;

/**
 * Service responsible for creating ratings.
 */
final readonly class RatingCreator
{
    /**
     * Constructs new RatingCreator instance.
     *
     * @param RatingRepository $ratingRepository The repository for managing ratings.
     */
    public function __construct(
        private RatingRepository $ratingRepository
    ) {
    }

    /**
     * Creates new rating based on the provided rating DTO.
     *
     * @param RatingDTO $ratingDTO The DTO containing rating information.
     * @return Rating The created rating entity.
     * @throws RatingAlreadyExists If a rating already exists for given user.
     */
    public function createRating(
        RatingDTO $ratingDTO
    ): Rating
    {
        $this->ensureRatingNotExist(
            MovieId::fromString($ratingDTO->movieId),
            UserId::fromString($ratingDTO->userId)
        );

        $rating = Rating::create(
            MovieId::fromString($ratingDTO->movieId),
            UserId::fromString($ratingDTO->userId),
            AverageRating::fromFloat($ratingDTO->averageRating)
        );
        $this->ratingRepository->add($rating);
        return $rating;
    }

    /**
     * Ensures that rating does not already exist for given user.
     *
     * @param MovieId $movieId The ID of movieId.
     * @param UserId $userId The ID of user.
     * @throws RatingAlreadyExists If a rating already exists for user.
     */
    private function ensureRatingNotExist(MovieId $movieId, UserId $userId): void
    {
        $rating = $this->ratingRepository->findByUserId($movieId, $userId);
        if ($rating !== null) {
            throw new RatingAlreadyExists($userId);
        }
    }
}
