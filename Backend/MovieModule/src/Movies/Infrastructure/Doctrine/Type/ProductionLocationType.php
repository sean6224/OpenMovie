<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Type;

use App\Common\Infrastructure\Doctrine\Type\StringType;
use App\Movies\Domain\ValueObject\MovieProductionLocation;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Custom Doctrine type for mapping MovieProductionLocation value objects to database columns.
 */
class ProductionLocationType extends StringType
{
    public const TYPE = 'productionLocation';

    /**
     * Converts a database value to its PHP representation.
     *
     * @param mixed $value The value from the database.
     * @param AbstractPlatform $platform The database platform.
     * @return MovieProductionLocation The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): MovieProductionLocation
    {
        return MovieProductionLocation::fromString((string)$value);
    }
}
