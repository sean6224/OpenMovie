<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Type;

use App\Common\Infrastructure\Doctrine\Type\StringType;
use App\Movies\Domain\ValueObject\MovieCategory;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Custom Doctrine type for mapping MovieCategory value objects to database columns.
 */
class CategoryType extends StringType
{
    public const TYPE = 'category';

    /**
     * Converts a database value to its PHP representation.
     *
     * @param mixed $value The value from the database.
     * @param AbstractPlatform $platform The database platform.
     * @return MovieCategory The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): MovieCategory
    {
        return MovieCategory::fromString((string) $value);
    }
}
