<?php
declare(strict_types=1);
namespace App\Ratings\Domain\ValueObject;

use App\Common\Domain\ValueObject\FloatValue;
use App\Ratings\Domain\Exception\AverageRatingInvalid;

final class AverageRating extends FloatValue
{
    public function __construct(float $value)
    {
        if ($value < 0.0 || $value > 10.0) {
            throw new AverageRatingInvalid();
        }

        parent::__construct($value);
    }
    public function __toString(): string
    {
        return (string) $this->value;
    }
}
