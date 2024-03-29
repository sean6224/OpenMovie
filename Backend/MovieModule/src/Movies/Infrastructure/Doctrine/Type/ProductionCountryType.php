<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Type;

use App\Common\Infrastructure\Doctrine\Type\StringType;
use App\Movies\Domain\ValueObject\MovieProductionCountry;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Custom Doctrine type for mapping MovieProductionCountry value objects to database columns.
 */
class ProductionCountryType extends StringType
{
    public const TYPE = 'productionCountry';

    /**
     * Converts a database value to its PHP representation.
     *
     * @param mixed $value The value from the database.
     * @param AbstractPlatform $platform The database platform.
     * @return MovieProductionCountry The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): MovieProductionCountry
    {
        return MovieProductionCountry::fromString((string)$value);
    }
}
