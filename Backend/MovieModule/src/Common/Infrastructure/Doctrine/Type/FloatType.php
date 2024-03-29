<?php
declare(strict_types=1);
namespace App\Common\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\FloatType as DoctrineFloatType;

abstract class FloatType extends DoctrineFloatType
{
    protected const TYPE = 'float';

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getFloat(): float
    {
        return (float) static::TYPE;
    }
}
