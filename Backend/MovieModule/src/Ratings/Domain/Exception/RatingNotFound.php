<?php
declare(strict_types=1);
namespace App\Ratings\Domain\Exception;

use App\Common\Domain\ValueObject\Id;
use DomainException;

/**
 * Exception thrown when a rating is not found for a given ID.
 */
final class RatingNotFound extends DomainException
{
    protected const INVALID_MESSAGE = 'The Rating was not found for id "%s"';

    /**
     * Constructs a new RatingNotFound instance.
     *
     * @param Id $ratingId The ID of the rating that was not found.
     */
    public function __construct(Id $ratingId)
    {
        $invalid = sprintf(self::INVALID_MESSAGE, $ratingId);
        parent::__construct($invalid);
    }
}
