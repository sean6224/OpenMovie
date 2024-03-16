<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Doctrine\Type;

use App\Common\Domain\ValueObject\Id;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class IdType extends StringType
{
    public const TYPE = 'id';

    public function convertToPHPValue($value, AbstractPlatform $platform): Id
    {
        return Id::fromString((string) $value);
    }
}
