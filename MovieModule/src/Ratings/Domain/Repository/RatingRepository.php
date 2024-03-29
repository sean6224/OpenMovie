<?php
declare(strict_types=1);
namespace App\Ratings\Domain\Repository;

use App\Ratings\Domain\Entity\Rating;
use App\Common\Domain\ValueObject\Id;
use App\Ratings\Domain\ValueObject\MovieId;
use App\Common\Domain\ValueObject\UserId;
use App\Ratings\Domain\Exception\RatingNotFound;
use App\Common\Domain\Repository\Repository;

/**
 * Interface for managing ratings in the repository.
 *
 * This interface extends the base Repository interface and provides methods
 * for adding, removing, retrieving, and searching ratings.
 *
 * @extends Repository<Rating>
 */
interface RatingRepository extends Repository
{
    /**
     * Adds rating to repository.
     *
     * @param Rating $rating The rating entity to add.
     * @return void
     */
    public function add(Rating $rating): void;

    /**
     * Removes rating from repository.
     *
     * @param Rating $rating The rating entity to remove.
     * @return void
     */
    public function remove(Rating $rating): void;

    /**
     * Retrieves rating by its unique identifier.
     *
     * @param Id $id The unique identifier of rating.
     * @return Rating The retrieved rating entity.
     * @throws RatingNotFound If the rating with the specified ID is not found.
     */
    public function get(Id $id): Rating;

    /**
     * Finds rating.
     *
     * @return Rating|null The last rating entity, or null if no ratings are found.
     */
    public function findLastRating(): ?Rating;

    /**
     * Finds rating by user ID.
     *
     * @param MovieId $movieId The movie ID.
     * @param UserId $userId The user ID.
     * @return Rating|null The rating entity, or null if not found.
     */
    public function findByUserId(MovieId $movieId, UserId $userId): ?Rating;

    /**
     * Searches for movies based on pagination, sorting, and filtering criteria.
     *
     * @param int $page The page number of the search results.
     * @param int $perPage The number of items per page.
     * @param string $sortBy The field to sort the results by.
     * @param string $sortOrder The sorting order ('asc' or 'desc').
     * @return array An array of Movie entities matching the search criteria.
     */

    public function search(int $page, int $perPage, string $sortBy, string $sortOrder): array;
}
