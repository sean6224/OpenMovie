<?php
declare(strict_types=1);
namespace App\Ratings\UserInterface\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Ratings\Application\DTO\RatingDTO;
use App\Ratings\UserInterface\ApiPlatform\Processor\CreateRatingProcessor;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Represents a resource for movies.
 *
 * This class defines the API resource for managing movies, including endpoints for creating, retrieving, and listing movies.
 */
#[ApiResource(
    shortName: 'RatingResource',
    operations: [
        new Post(
            uriTemplate: '/movie/ratings/add',
            openapiContext: ['summary' => 'Adds a new rating for movie'],
            denormalizationContext: ['groups' => ['send']],
            validationContext: ['groups' => ['read', 'send']],
            processor: CreateRatingProcessor::class,
        ),
    ]
)]

/**
 * Represents a resource for movie ratings.
 *
 * This class defines the API resource for managing movie ratings, including endpoints for various operations such as creating, retrieving, and deleting ratings.
 * It provides functionality for managing movie ratings through API endpoints.
 */
class RatingResource
{
    public function __construct(
        #[Groups(groups: ['read'])]
        public ?string $id = null,

        #[Groups(groups: ['send'])]
        public ?string $movieId = null,

        #[Groups(groups: ['send'])]
        public ?string $userId = null,

        #[Groups(groups: ['send', 'accept'])]
        public float $averageRating = 0.0
    ) {
    }

    /**
     * Constructs a RatingResource object from a RatingDTO instance.
     *
     * @param RatingDTO $ratingDTO The RatingDTO instance containing data for constructing RatingResource.
     * @return self new RatingResource instance constructed from RatingDTO data.
     */
    public static function fromRatingDTO(RatingDTO $ratingDTO): self
    {
        return new self(
            id: $ratingDTO->id,
            movieId: $ratingDTO->movieId,
            userId: $ratingDTO->userId,
            averageRating: $ratingDTO->averageRating
        );
    }
}
