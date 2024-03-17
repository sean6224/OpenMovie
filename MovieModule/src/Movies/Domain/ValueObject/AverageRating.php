<?php
declare(strict_types=1);
namespace App\Movies\Domain\ValueObject;

use App\Common\Domain\ValueObject\FloatValue;
final class AverageRating extends FloatValue
{
    public function __toString(): string
    {
        return (string) $this->value;
    }
}
