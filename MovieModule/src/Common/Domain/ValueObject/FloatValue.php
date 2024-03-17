<?php
declare(strict_types=1);
namespace App\Common\Domain\ValueObject;

abstract class FloatValue
{
    protected float $value;

    private function __construct(float $value)
    {
        $this->value = $value;
    }

    public static function fromFloat(float $value): static
    {
        return new static($value);
    }

    public function value(): float
    {
        return $this->value;
    }
}
