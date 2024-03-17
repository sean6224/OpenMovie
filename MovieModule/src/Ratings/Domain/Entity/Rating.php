<?php
declare(strict_types=1);
namespace App\Ratings\Domain\Entity;

use App\Common\Domain\Entity\AggregateRoot;
use App\Common\Domain\ValueObject\DateTime;
use App\Common\Domain\ValueObject\Id;

use App\Ratings\Domain\ValueObject\MovieId;
use App\Ratings\Domain\ValueObject\UserId;
use App\Ratings\Domain\ValueObject\AverageRating;

/**
 * Represents Rating entity in the domain.
 */
class Rating extends AggregateRoot
{
    private Id $id;
    private MovieId $movieId;
    private UserId $userId;
    private AverageRating $averageRating;
    private DateTime $createdAt;

    /**
     * Constructs new Rating instance.
     *
     * @param MovieId $movieId The ID of the movie associated with the rating.
     * @param UserId $userId The ID of the user who rated the movie.
     * @param AverageRating $averageRating The average rating given to the movie.
     */
    private function __construct(
        MovieId $movieId,
        UserId $userId,
        AverageRating $averageRating
    )
    {
        $this->id = Id::generate();
        $this->createdAt = DateTime::now();

        $this->movieId = $movieId;
        $this->userId = $userId;
        $this->averageRating = $averageRating;
    }

    /**
     * Factory method for creating new Rating instance.
     *
     * @param MovieId $movieId The ID of the movie associated with the rating.
     * @param UserId $userId The ID of the user who rated the movie.
     * @param AverageRating $averageRating The average rating given to the movie.
     * @return Rating A new instance of the Rating entity.
     */
    public static function create(
        MovieId $movieId,
        UserId $userId,
        AverageRating $averageRating
    ): self {
        return new self(
            movieId: $movieId,
            userId: $userId,
            averageRating: $averageRating
        );
    }

    /**
     * Gets the ID of rating.
     *
     * @return Id The ID of rating.
     */
    public function id(): Id
    {
        return $this->id;
    }

    /**
     * Gets the ID of movie associated with rating.
     *
     * @return MovieId The ID of movie.
     */
    public function movieId(): MovieId
    {
        return $this->movieId;
    }

    /**
     * Gets the ID of user who rated movie.
     *
     * @return UserId The ID of user.
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * Gets the average rating given to movie.
     *
     * @return AverageRating The average rating.
     */
    public function averageRating(): AverageRating
    {
        return $this->averageRating;
    }

    /**
     * Gets the date and time when the rating was created.
     *
     * @return DateTime The creation date and time.
     */
    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }
}
