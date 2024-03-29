<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Type;

use App\Common\Infrastructure\Doctrine\Type\IntType;
use App\Movies\Domain\ValueObject\Duration;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Custom Doctrine type for mapping Duration value objects to database columns.
 */
class DurationType extends IntType
{
    public const TYPE = 'duration';

    /**
     * Converts a database value to its PHP representation.
     *
     * @param mixed $value The value from the database.
     * @param AbstractPlatform $platform The database platform.
     * @return Duration The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): Duration
    {
        return Duration::fromInt((int) $value);
    }
}
