<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Type;

use App\Common\Infrastructure\Doctrine\Type\StringType;
use App\Movies\Domain\ValueObject\MovieSubtitles;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Custom Doctrine type for mapping MovieSubtitles value objects to database columns.
 */
class SubtitlesType extends StringType
{
    public const TYPE = 'subtitles';

    /**
     * Converts a database value to its PHP representation.
     *
     * @param mixed $value The value from the database.
     * @param AbstractPlatform $platform The database platform.
     * @return MovieSubtitles The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): MovieSubtitles
    {
        return MovieSubtitles::fromString((string) $value);
    }
}
