<?php
declare(strict_types=1);
namespace App\Movies\Domain\ValueObject;

use App\Common\Domain\ValueObject\IntegerValue;
final class AgeRestriction extends IntegerValue
{
    public function __toString(): string
    {
        return (string) $this->value;
    }
}
