<?php
declare(strict_types=1);
namespace App\Ratings\Domain\Repository;

use App\Ratings\Domain\Entity\Rating;
use App\Common\Domain\ValueObject\Id;
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
}
