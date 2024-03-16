<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Type;

use App\Common\Infrastructure\Doctrine\Type\StringType;
use App\Movies\Domain\ValueObject\MovieDirectors;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Custom Doctrine type for mapping MovieDirectors value objects to database columns.
 */
class DirectorType extends StringType
{
    public const TYPE = 'movieDirectors';

    /**
     * Converts a database value to its PHP representation.
     *
     * @param mixed $value The value from the database.
     * @param AbstractPlatform $platform The database platform.
     * @return MovieDirectors The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): MovieDirectors
    {
        return MovieDirectors::fromString((string)$value);
    }
}
