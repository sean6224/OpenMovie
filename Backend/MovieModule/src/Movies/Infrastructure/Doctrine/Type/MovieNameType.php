<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Type;

use App\Common\Infrastructure\Doctrine\Type\StringType;
use App\Movies\Domain\ValueObject\MovieName;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Custom Doctrine type for mapping MovieName value objects to database columns.
 */
class MovieNameType extends StringType
{
    public const TYPE = 'movie_name';

    /**
     * Converts a database value to its PHP representation.
     *
     * @param mixed $value The value from the database.
     * @param AbstractPlatform $platform The database platform.
     * @return MovieName The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): MovieName
    {
        return MovieName::fromString((string) $value);
    }
}
