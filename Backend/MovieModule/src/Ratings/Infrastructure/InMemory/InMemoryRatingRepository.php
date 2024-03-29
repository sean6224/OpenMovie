<?php
declare(strict_types=1);
namespace App\Ratings\Infrastructure\InMemory;

use App\Common\Domain\ValueObject\UserId;
use App\Ratings\Domain\Entity\Rating;
use App\Ratings\Domain\Repository\RatingRepository;
use App\Common\Domain\ValueObject\Id;
use App\Ratings\Domain\Exception\RatingNotFound;
use App\Common\Infrastructure\InMemory\InMemoryRepository;
use App\Ratings\Domain\ValueObject\MovieId;

/**
 * In-memory implementation of the RatingRepository interface.
 *
 * This repository stores rating entities in-memory, providing basic CRUD operations.
 *
 * @implements RatingRepository
 */
final class InMemoryRatingRepository extends InMemoryRepository implements RatingRepository
{
    /**
     * Adds rating to repository.
     *
     * @param Rating $rating The rating entity to add.
     * @return void
     */
    public function add(Rating $rating): void
    {
        $this->entities[(string)$rating->id()] = $rating;
    }

    /**
     * Removes rating from repository.
     *
     * @param Rating $rating The rating entity to remove.
     * @return void
     */
    public function remove(Rating $rating): void
    {
        unset($this->entities[(string)$rating->id()]);
    }

    /**
     * Retrieves rating by its unique identifier.
     *
     * @param Id $id The unique identifier of rating.
     * @return Rating The retrieved rating entity.
     * @throws RatingNotFound If the rating with the specified ID is not found.
     */
    public function get(Id $id): Rating
    {
        $rating = $this->entities[(string)$id] ?? null;
        if ($rating === null) {
            throw new RatingNotFound($id);
        }
        return $rating;
    }

    /**
     * Retrieves last added rating from repository.
     *
     * @return Rating|null The last added rating entity, or null if no rating are found.
     */
    public function findLastRating(): ?Rating
    {
        end($this->entities);
        $lastRating = current($this->entities);
        return $lastRating ?: null;
    }

    /**
     * Finds rating by user ID and movie ID.
     *
     * @param MovieId $movieId The movie ID.
     * @param UserId $userId The user ID.
     * @return Rating|null The rating entity if found, or null if not found.
     */
    public function findByUserId(MovieId $movieId, UserId $userId): ?Rating
    {
        foreach ($this->entities as $rating) {
            if ($rating->movieId()->equals($movieId) && $rating->userId()->equals($userId)) {
                return $rating;
            }
        }
        return null;
    }

    /**
     * Searches for rating based on pagination, sorting, and filtering criteria.
     *
     * @param int $page The page number of the search results.
     * @param int $perPage The number of items per page.
     * @param string $sortBy The field to sort the results by.
     * @param string $sortOrder The sorting order ('asc' or 'desc').
     * @return array An array of Rating entities matching search criteria.
     */
    public function search(int $page, int $perPage, string $sortBy, string $sortOrder): array
    {
        // Implementation of search functionality goes here
        // This method is not implemented in the code snippet
        return [];
    }
}
