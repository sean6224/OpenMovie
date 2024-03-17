<?php
declare(strict_types=1);
namespace App\Movies\Domain\Exception;

use DomainException;

/**
 * Exception thrown when attempting to create an entity with an invalid average rating.
 */
final class AverageRatingInvalid extends DomainException
{
    /**
     * Constructs a new AverageRatingInvalid instance.
     */
    protected const INVALID_MESSAGE = 'Average rating must be between 0.0 and 10.0.';

    public function __construct()
    {
        parent::__construct(self::INVALID_MESSAGE);
    }
}

