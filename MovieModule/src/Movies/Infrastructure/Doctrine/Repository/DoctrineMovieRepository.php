<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Repository;

use App\Common\Domain\ValueObject\Id;
use App\Movies\Domain\ValueObject\MovieName;
use App\Movies\Domain\Entity\Movie;
use App\Movies\Domain\Exception\MovieNotFound;
use App\Movies\Domain\Repository\MovieRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\{QueryBuilder, EntityManagerInterface};
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository implementation using Doctrine ORM for managing Movie entities.
 */
class DoctrineMovieRepository extends ServiceEntityRepository implements MovieRepository
{
    public const ALIAS = 'movie';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    /**
     * Creates a base QueryBuilder instance for this repository's entity.
     *
     * @return QueryBuilder A QueryBuilder instance.
     */
    private function createBaseQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder(self::ALIAS);
    }

    /**
     * Persists a movie entity.
     *
     * @param Movie $movie The movie entity to add.
     * @return void
     */
    public function add(Movie $movie): void
    {
        $this->getEntityManager()->persist($movie);
    }

    /**
     * Removes a movie entity.
     *
     * @param Movie $movie The movie entity to remove.
     * @return void
     */
    public function remove(Movie $movie): void
    {
        $this->getEntityManager()->remove($movie);
    }

    /**
     * Retrieves a movie entity by its ID.
     *
     * @param Id $id The ID of the movie.
     * @return Movie The retrieved movie entity.
     * @throws MovieNotFound If the movie with the given ID is not found.
     */
    public function get(Id $id): Movie
    {
        /** @var ?Movie $movie */
        $movie = $this->find($id);
        if (null === $movie) {
            throw new MovieNotFound($id);
        }
        return $movie;
    }

    /**
     * Retrieves all movies.
     *
     * @return Movie[]
     */
    public function findAll(): array
    {
        return $this->createQueryBuilder('m')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrieves a movie entity by its name.
     *
     * @param MovieName $movieName The name of the movie.
     * @return Movie|null The retrieved movie entity, or null if not found.
     */
    public function findByMovieName(MovieName $movieName): ?Movie
    {
        return $this->findOneBy(['movieName' => $movieName]);
    }

    /**
     * Searches for movies based on pagination parameters.
     *
     * @param int $page The page number for pagination.
     * @param int $perPage The number of items per page.
     * @param string $sortBy The field to sort the results by.
     * @param string $sortOrder The sorting order ('ASC' or 'DESC').
     * @return array An array of Movie entities.
     */
    public function search(int $page, int $perPage, string $sortBy, string $sortOrder): array
    {
        $queryBuilder = $this->createBaseQueryBuilder();
        $queryBuilder
            ->setFirstResult(($page - 1) * $perPage)
            ->setMaxResults($perPage)
            ->orderBy(self::ALIAS . '.' . $sortBy, $sortOrder);

        return $queryBuilder->getQuery()->getResult();
    }
}
