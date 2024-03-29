<?php
declare(strict_types=1);
namespace App\Movies\Domain\Exception;

use App\Common\Domain\ValueObject\Id;
use DomainException;

/**
 * Exception thrown when a movie is not found for a given ID.
 */
final class MovieNotFound extends DomainException
{
    protected const INVALID_MESSAGE = 'The Movie was not found for id "%s".';

    /**
     * Constructs a new MovieNotFound instance.
     *
     * @param Id $movieId The ID of the movie that was not found.
     */
    public function __construct(Id $movieId)
    {
        $invalid = sprintf(self::INVALID_MESSAGE, $movieId);
        parent::__construct($invalid);
    }
}
