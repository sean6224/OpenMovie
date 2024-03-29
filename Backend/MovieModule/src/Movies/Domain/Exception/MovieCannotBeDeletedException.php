<?php
declare(strict_types=1);
namespace App\Movies\Domain\Exception;

use App\Common\Domain\ValueObject\Id;
use DomainException;

/**
 * Exception thrown when a movie cannot be deleted.
 */
final class MovieCannotBeDeletedException extends DomainException
{
    protected const INVALID_MESSAGE = 'Failed to delete Movie with ID: "%s"';

    /**
     * Constructs a new MovieCannotBeDeletedException instance.
     *
     * @param Id $id The ID of the movie that cannot be deleted.
     */
    public function __construct(Id $id)
    {
        $message = sprintf(self::INVALID_MESSAGE, $id->value());
        parent::__construct($message);
    }
}
