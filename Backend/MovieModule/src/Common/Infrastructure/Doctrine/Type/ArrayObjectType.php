<?php
declare(strict_types=1);
namespace App\Common\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class ArrayObjectType extends Type
{
    const ARRAY_OBJECT_TYPE = 'array_object';

    /**
     * Returns the SQL declaration for a database field.
     *
     * @param array $column The field declaration options.
     * @param AbstractPlatform $platform The platform instance.
     * @return string The SQL declaration for the field.
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'BYTEA';
    }

    /**
     * Converts a value from its database representation to its PHP representation.
     *
     * @param mixed $value The value to be converted.
     * @param AbstractPlatform $platform The platform instance.
     * @return array The converted value in PHP representation.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): array
    {
        $valueArray = [];

        if (!empty($value)) {
            $value = $this->getResourceContent($value);
            $valueArray = $this->getUnpackedValue($value);
        }

        return $valueArray;
    }

    /**
     * Gets the content of a resource if it is a valid resource.
     *
     * @param mixed $value The value to be checked and retrieved the content from if it is a resource.
     * @return mixed The content of the resource, or the original value if it is not a resource.
     */
    private function getResourceContent(mixed $value)
    {
        if (is_resource($value)) {
            $content = stream_get_contents($value);
            if ($content !== false) {
                $value = $content;
            }
        }
        return $value;
    }

    /**
     * Gets the unpacked value of the input packed hexadecimal value.
     *
     * @param mixed $value The packed hexadecimal value to be unpacked.
     * @return array The unpacked value as an array, or an empty array if the input value is not a valid packed hexadecimal value or the unpacked value is not an array.
     */
    private function getUnpackedValue(mixed $value): array
    {
        if (is_string($value)) {
            $packedValue = @pack('H*', $value);
            if ($packedValue) {
                $unpackedValue = msgpack_unpack($packedValue);
                if (is_array($unpackedValue)) {
                    return $unpackedValue;
                }
            }
        }
        return [];
    }

    /**
     * Converts a value to its database representation.
     *
     * @param mixed $value The value to be converted.
     * @param AbstractPlatform $platform The platform instance.
     * @return mixed The converted value.
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if (!empty($value)) {
            $value = $this->getPackedHexValue($value);
        }
        return $value;
    }

    /**
     * Gets the packed hexadecimal value of the input value.
     *
     * @param mixed $value The value to be packed.
     * @return string The packed hexadecimal value.
     */
    private function getPackedHexValue(mixed $value): string
    {
        $packedValue = msgpack_pack($value);
        return bin2hex($packedValue);
    }

    public function getName(): string
    {
        return self::ARRAY_OBJECT_TYPE;
    }
}
