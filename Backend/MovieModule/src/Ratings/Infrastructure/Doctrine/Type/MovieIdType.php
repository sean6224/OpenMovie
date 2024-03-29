<?php
declare(strict_types=1);
namespace App\Ratings\Infrastructure\Doctrine\Type;

use App\Common\Infrastructure\Doctrine\Type\UuidType;
use App\Ratings\Domain\ValueObject\MovieId;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Custom Doctrine type for mapping MovieId value objects to database columns.
 */
class MovieIdType extends UuidType
{
    public const TYPE = 'movie_id';

    /**
     * Converts a database value to its PHP representation.
     *
     * @param mixed $value The value from the database.
     * @param AbstractPlatform $platform The database platform.
     * @return MovieId The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): MovieId
    {
        return MovieId::fromString((string)$value);
    }
}
