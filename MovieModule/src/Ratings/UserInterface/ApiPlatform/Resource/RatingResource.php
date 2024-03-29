<?php
declare(strict_types=1);
namespace App\Ratings\UserInterface\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;

use App\Ratings\Application\DTO\RatingDTO;
use App\Ratings\UserInterface\ApiPlatform\Processor\CreateRatingProcessor;
use App\Ratings\UserInterface\ApiPlatform\Processor\PatchRatingProcessor;
use App\Ratings\UserInterface\ApiPlatform\Provider\RatingCollectionProvider;
use App\Ratings\UserInterface\ApiPlatform\Provider\SingleRatingProvider;
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
            openapiContext: ['summary' => 'Initiates addition of new movie rating'],
            denormalizationContext: ['groups' => ['send']],
            validationContext: ['groups' => ['read', 'send']],
            processor: CreateRatingProcessor::class,
        ),
        new GetCollection(
            uriTemplate: '/movie/ratings/get/all_list',
            openapiContext: ['summary' => 'Retrieves comprehensive list of all movie ratings'],
            provider: RatingCollectionProvider::class,
        ),
        new Get(
            uriTemplate: '/movie/ratings/get/single/{id}',
            openapiContext: ['summary' => 'Fetches detailed information about specific movie rating'],
            provider: SingleRatingProvider::class,
        ),

        new Patch(
            uriTemplate: '/movie/ratings/{id}',
            openapiContext: ['summary' => 'Allows modification of an existing movie rating, ensuring accuracy and relevance of user-contributed assessments over time'],
            denormalizationContext: ['groups' => ['patch']],
            provider: SingleRatingProvider::class,
            processor: PatchRatingProcessor::class,
        )
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

        #[Groups(groups: ['send', 'return'])]
        public ?string $movieId = null,

        #[Groups(groups: ['send'])]
        public ?string $userId = null,

        #[Groups(groups: ['send', 'patch'])]
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
