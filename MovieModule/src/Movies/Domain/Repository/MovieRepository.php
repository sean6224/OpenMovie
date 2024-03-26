<?php
declare(strict_types=1);
namespace App\Movies\Domain\Repository;

use App\Movies\Domain\Entity\Movie;
use App\Common\Domain\ValueObject\Id;
use App\Movies\Domain\ValueObject\MovieName;
use App\Movies\Domain\Exception\MovieNotFound;
use App\Common\Domain\Repository\Repository;

/**
 * Interface for managing movies in the repository.
 *
 * This interface extends the base Repository interface and provides methods
 * for adding, removing, retrieving, and searching movies.
 *
 * @extends Repository<Movie>
 */

interface MovieRepository extends Repository
{
    /**
     * Adds a movie to the repository.
     *
     * @param Movie $movie The movie entity to add.
     * @return void
     */
    public function add(Movie $movie): void;

    /**
     * Removes a movie from the repository.
     *
     * @param Movie $movie The movie entity to remove.
     * @return void
     */
    public function remove(Movie $movie): void;

    /**
     * Retrieves a movie by its unique identifier.
     *
     * @param Id $id The unique identifier of the movie.
     * @return Movie The retrieved movie entity.
     * @throws MovieNotFound If the movie with the specified ID is not found.
     */
    public function get(Id $id): Movie;

    /**
     * Finds the movie.
     *
     * @return Movie|null The last movie entity, or null if no movies are found.
     */
    public function findLastMovie(): ?Movie;

    /**
     * Finds a movie by its name.
     *
     * @param MovieName $movieName The name of the movie to find.
     * @return Movie|null The found movie entity, or null if not found.
     */
    public function findByMovieName(MovieName $movieName): ?Movie;

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
