<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Type;

use App\Common\Infrastructure\Doctrine\Type\StringType;
use App\Movies\Domain\ValueObject\ReleaseYear;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Custom Doctrine type for mapping ReleaseYear value objects to database columns.
 */
class ReleaseYearType extends StringType
{
    public const TYPE = 'releaseYear';

    /**
     * Converts a database value to its PHP representation.
     *
     * @param mixed $value The value from the database.
     * @param AbstractPlatform $platform The database platform.
     * @return ReleaseYear The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ReleaseYear
    {
        return ReleaseYear::fromString((string) $value);
    }
}
