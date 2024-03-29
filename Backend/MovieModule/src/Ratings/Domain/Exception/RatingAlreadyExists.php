<?php
declare(strict_types=1);
namespace App\Ratings\Domain\Exception;

use App\Common\Domain\ValueObject\UserId;
use DomainException;

/**
 * Exception thrown when attempting to create a rating that already exists.
 */
final class RatingAlreadyExists extends DomainException
{
    /**
     * Constructs a new RatingAlreadyExists instance.
     *
     * @param string $userId The ID of the user for whom the rating already exists.
     */
    protected const INVALID_MESSAGE = 'A rating already exists for user with ID "%s"';

    public function __construct(UserId $userId)
    {
        $invalid = sprintf(self::INVALID_MESSAGE, $userId);
        parent::__construct($invalid);
    }
}
