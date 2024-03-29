<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\InMemory;

use App\Movies\Domain\Entity\Movie;
use App\Movies\Domain\Repository\MovieRepository;
use App\Common\Domain\ValueObject\Id;
use App\Movies\Domain\ValueObject\MovieName;
use App\Movies\Domain\Exception\MovieNotFound;
use App\Common\Infrastructure\InMemory\InMemoryRepository;

/**
 * In-memory implementation of the MovieRepository interface.
 *
 * This repository stores movie entities in-memory, providing basic CRUD operations.
 *
 * @implements MovieRepository
 */
final class InMemoryMovieRepository extends InMemoryRepository implements MovieRepository
{
    /**
     * Adds a movie to the repository.
     *
     * @param Movie $movie The movie entity to add.
     * @return void
     */
    public function add(Movie $movie): void
    {
        $this->entities[(string)$movie->id()] = $movie;
    }

    /**
     * Removes a movie from the repository.
     *
     * @param Movie $movie The movie entity to remove.
     * @return void
     */
    public function remove(Movie $movie): void
    {
        unset($this->entities[(string)$movie->id()]);
    }

    /**
     * Retrieves a movie by its unique identifier.
     *
     * @param Id $id The unique identifier of the movie.
     * @return Movie The retrieved movie entity.
     * @throws MovieNotFound If the movie with the specified ID is not found.
     */
    public function get(Id $id): Movie
    {
        $movie = $this->entities[(string)$id] ?? null;
        if ($movie === null) {
            throw new MovieNotFound($id);
        }
        return $movie;
    }

    /**
     * Retrieves the last added movie from repository.
     *
     * @return Movie|null The last added movie entity, or null if no movies are found.
     */
    public function findLastMovie(): ?Movie
    {
        end($this->entities);
        $lastMovie = current($this->entities);
        return $lastMovie ?: null;
    }


    /**
     * Finds a movie by its name.
     *
     * @param MovieName $movieName The name of the movie to find.
     * @return Movie|null The found movie entity, or null if not found.
     */
    public function findByMovieName(MovieName $movieName): ?Movie
    {
        foreach ($this->entities as $movie) {
            if ($movie->name()->equals($movieName)) {
                return $movie;
            }
        }
        return null;
    }

    /**
     * Searches for movies based on pagination, sorting, and filtering criteria.
     *
     * @param int $page The page number of the search results.
     * @param int $perPage The number of items per page.
     * @param string $sortBy The field to sort the results by.
     * @param string $sortOrder The sorting order ('asc' or 'desc').
     * @return array An array of Movie entities matching the search criteria.
     */
    public function search(int $page, int $perPage, string $sortBy, string $sortOrder): array
    {
        // Implementation of search functionality goes here
        // This method is not implemented in the code snippet
        return [];
    }
}
