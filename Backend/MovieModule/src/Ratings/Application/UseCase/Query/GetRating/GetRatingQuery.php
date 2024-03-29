<?php
declare(strict_types=1);
namespace App\Ratings\Application\UseCase\Query\GetRating;

use App\Common\Application\Query\Query;

/**
 * Query for retrieving information about single movie rating.
 *
 * This query is used to fetch details of specific movie rating based on its unique identifier (ID).
 */
final class GetRatingQuery implements Query
{
    /**
     * Constructs a new GetRatingQuery instance.
     *
     * @param string $ratingId The unique identifier (ID) of rating.
     */
    public function __construct(
        public string $ratingId
    ) {
    }
}
