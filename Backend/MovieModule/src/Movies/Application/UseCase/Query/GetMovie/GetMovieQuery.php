<?php
declare(strict_types=1);
namespace App\Movies\Application\UseCase\Query\GetMovie;

use App\Common\Application\Query\Query;

/**
 * Query for retrieving information about a single movie.
 *
 * This query is used to fetch details of a specific movie based on its unique identifier (ID).
 */
final readonly class GetMovieQuery implements Query
{
    /**
     * Constructs a new GetMovieQuery instance.
     *
     * @param string $movieId The unique identifier (ID) of the movie.
     */
    public function __construct(
        public string $movieId
    ){
    }
}
