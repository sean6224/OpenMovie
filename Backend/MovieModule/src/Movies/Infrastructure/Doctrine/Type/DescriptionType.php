<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Type;

use App\Common\Infrastructure\Doctrine\Type\StringType;
use App\Movies\Domain\ValueObject\Description;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Custom Doctrine type for mapping Description value objects to database columns.
 */
class DescriptionType extends StringType
{
    public const TYPE = 'description';

    /**
     * Converts a database value to its PHP representation.
     *
     * @param mixed $value The value from the database.
     * @param AbstractPlatform $platform The database platform.
     * @return Description The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): Description
    {
        return Description::fromString((string) $value);
    }
}
