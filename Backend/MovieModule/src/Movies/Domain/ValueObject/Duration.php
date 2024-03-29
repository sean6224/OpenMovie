<?php
declare(strict_types=1);
namespace App\Movies\Domain\ValueObject;

use App\Common\Domain\ValueObject\IntegerValue;
final class Duration extends IntegerValue
{
    public function __toString(): string
    {
        return (string) $this->value;
    }
}
