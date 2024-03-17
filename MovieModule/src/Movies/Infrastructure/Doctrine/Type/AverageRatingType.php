<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Type;

use App\Common\Infrastructure\Doctrine\Type\IntType;
use App\Movies\Domain\ValueObject\AverageRating;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Custom Doctrine type for mapping AverageRating  value objects to database columns.
 */
class AverageRatingType extends IntType
{
    public const TYPE = 'averageRating';

    /**
     * Converts a database value to its PHP representation.
     *
     * @param mixed $value The value from the database.
     * @param AbstractPlatform $platform The database platform.
     * @return AverageRating The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): AverageRating
    {
        return AverageRating::fromFloat($value);
    }
}
