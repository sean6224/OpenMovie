<?php
declare(strict_types=1);
namespace App\Ratings\Infrastructure\Doctrine\Repository;

use App\Common\Domain\ValueObject\Id;
use App\Common\Domain\ValueObject\UserId;
use App\Ratings\Domain\Entity\Rating;
use App\Ratings\Domain\Exception\RatingNotFound;
use App\Ratings\Domain\Repository\RatingRepository;
use App\Ratings\Domain\ValueObject\MovieId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository implementation using Doctrine ORM for managing Rating entities.
 */
class DoctrineRatingRepository extends ServiceEntityRepository implements RatingRepository
{
    public const ALIAS = 'rating';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rating::class);
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
     * Persists rating entity.
     *
     * @param Rating $rating The rating entity to add.
     * @return void
     */
    public function add(Rating $rating): void
    {
        $this->getEntityManager()->persist($rating);
    }

    /**
     * Removes rating entity.
     *
     * @param Rating $rating The rating entity to remove.
     * @return void
     */
    public function remove(Rating $rating): void
    {
        $this->getEntityManager()->remove($rating);
    }

    /**
     * Retrieves rating entity by its ID.
     *
     * @param Id $id The ID of rating.
     * @return Rating The retrieved rating entity.
     * @throws RatingNotFound If rating with given ID is not found.
     */
    public function get(Id $id): Rating
    {
        /** @var ?Rating $rating */
        $rating = $this->find($id);
        if (null === $rating) {
            throw new RatingNotFound($id);
        }
        return $rating;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findLastRating(): ?Rating
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
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
            ->setMaxResults($perPage);

        if ($sortBy !== '') {
            $queryBuilder->orderBy(self::ALIAS . '.' . $sortBy, $sortOrder);
        }
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Finds rating by user ID and movie ID.
     *
     * @param MovieId $movieId The movie ID.
     * @param UserId $userId The user ID.
     * @return Rating|null The rating entity, or null if not found.
     */
    public function findByUserId(MovieId $movieId, UserId $userId): ?Rating
    {
        return $this->findOneBy(['movieId' => $movieId, 'userId' => $userId]);
    }
}
