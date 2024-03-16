<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Type;

use App\Common\Infrastructure\Doctrine\Type\StringType;
use App\Movies\Domain\ValueObject\MovieLanguage;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Custom Doctrine type for mapping MovieLanguage value objects to database columns.
 */
class LanguageType extends StringType
{
    public const TYPE = 'language';

    /**
     * Converts a database value to its PHP representation.
     *
     * @param mixed $value The value from the database.
     * @param AbstractPlatform $platform The database platform.
     * @return MovieLanguage The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): MovieLanguage
    {
        return MovieLanguage::fromString((string) $value);
    }
}
