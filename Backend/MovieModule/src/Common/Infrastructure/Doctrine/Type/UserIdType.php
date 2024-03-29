<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Doctrine\Type;

use App\Common\Infrastructure\Doctrine\Type\UuidType;
use App\Common\Domain\ValueObject\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class UserIdType extends UuidType
{
    public const TYPE = 'user_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): UserId
    {
        return UserId::fromString((string) $value);
    }
}
