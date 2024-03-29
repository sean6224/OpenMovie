<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Type;

use App\Common\Infrastructure\Doctrine\Type\StringType;
use App\Movies\Domain\ValueObject\MovieActors;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Custom Doctrine type for mapping MovieActors value objects to database columns.
 */
class ActorType extends StringType
{
    public const TYPE = 'actor';

    /**
     * Converts a database value to its PHP representation.
     *
     * @param mixed $value The value from the database.
     * @param AbstractPlatform $platform The database platform.
     * @return MovieActors The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): MovieActors
    {
        return MovieActors::fromString((string) $value);
    }
}
