<?php
declare(strict_types=1);
namespace App\Movies\Application\Service;

use App\Movies\Domain\Repository\MovieRepository;
use App\Common\Domain\ValueObject\Id;
use Doctrine\ORM\EntityManagerInterface;
use App\Movies\Domain\Exception\MovieCannotBeDeletedException;
use Exception;

/**
 * Service for deleting Movie entities.
 */
final readonly class DeleteMovie
{
    /**
     * DeleteMovie constructor.
     *
     * @param MovieRepository       $movieRepository The repository for accessing movie data.
     * @param EntityManagerInterface $entityManager  The EntityManager for managing entity persistence.
     */
    public function __construct(
        private MovieRepository $movieRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * Deletes a Movie entity.
     *
     * @param Id $movieId The ID of the movie to be deleted.
     *
     * @throws MovieCannotBeDeletedException If the movie cannot be deleted.
     */
    public function deleteMovie(
        Id $movieId
    ): void
    {
        $this->entityManager->beginTransaction();
        try {
            $movie = $this->movieRepository->get($movieId);
            $this->movieRepository->remove($movie);
            $this->entityManager->commit();
        } catch (Exception) {
            $this->entityManager->rollback();
            throw new MovieCannotBeDeletedException($movieId);
        }
    }
}
