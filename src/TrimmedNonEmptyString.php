<?php

declare(strict_types=1);

namespace OskarStark\Value;

use Webmozart\Assert\Assert;
use function Symfony\Component\String\u;

final class TrimmedNonEmptyString
{
    private string $value;
    private string $message;

    /**
     * @throws \InvalidArgumentException
     */
    private function __construct(string $value, string $message)
    {
        $value = u($value)->trim()->toString();

        Assert::stringNotEmpty($value, $message);

        $this->value = $value;
    }

    public static function fromString(string $value, string $message = ''): self
    {
        return new self($value, $message);
    }

    public function toString(): string
    {
        return $this->value;
    }
}