<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

abstract class BoolValue
{
    protected function __construct(protected bool $value)
    {
    }

    public static function fromBool(bool $value): static
    {
        return new static($value);
    }

    public function value(): bool
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value ? 'true' : 'false';
    }

    public function isEqual(self $other): bool
    {
        return $this->value() === $other->value();
    }
}
