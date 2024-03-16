<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Type;

use App\Common\Infrastructure\Doctrine\Type\IntType;
use App\Movies\Domain\ValueObject\AgeRestriction;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Custom Doctrine type for mapping AgeRestriction value objects to database columns.
 */
class AgeRestrictionType extends IntType
{
    public const TYPE = 'ageRestriction';

    /**
     * Converts a database value to its PHP representation.
     *
     * @param mixed $value The value from the database.
     * @param AbstractPlatform $platform The database platform.
     * @return AgeRestriction The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): AgeRestriction
    {
        return AgeRestriction::fromInt((int)$value);
    }
}
