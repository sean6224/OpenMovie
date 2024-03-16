<?php
declare(strict_types=1);
namespace App\Common\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType as DoctrineIntType;

abstract class IntType extends DoctrineIntType
{
    protected const TYPE = 'int';

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getInt(): int
    {
        return (int) static::TYPE;
    }
}
