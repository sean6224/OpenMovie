<?php
declare(strict_types=1);
namespace App\Movies\Domain\Exception;

use App\Movies\Domain\ValueObject\MovieName;
use DomainException;

/**
 * Exception thrown when attempting to create a movie that already exists.
 */
final class MovieAlreadyExists extends DomainException
{
    /**
     * Constructs a new MovieAlreadyExists instance.
     *
     * @param string $movieName The name of the movie that already exists.
     */
    protected const INVALID_MESSAGE = 'The Movie with name "%s" already exists.';
    public function __construct(MovieName $movieName)
    {
        $invalid = sprintf(self::INVALID_MESSAGE, $movieName);
        parent::__construct($invalid);
    }
}
