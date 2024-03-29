<?php
declare(strict_types=1);
namespace App\Movies\Domain\Exception;

use DomainException;

/**
 * Exception thrown when required attributes are missing or empty.
 */
final class MissingOrEmptyAttributesException extends DomainException
{
    /**
     * Constructs new MissingOrEmptyAttributesException instance.
     *
     * @param string[] $missingAttributes An array of missing attributes.
     */
    public function __construct(array $missingAttributes)
    {
        $message = sprintf('Missing or empty required attributes: %s.', implode(', ', $missingAttributes));
        parent::__construct($message);
    }
}
