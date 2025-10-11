<?php

declare(strict_types=1);

/*
 * This file is part of oskarstark/trimmed-non-empty-string.
 *
 * (c) Oskar Stark <oskarstark@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OskarStark\Value;

use function Symfony\Component\String\u;

use Webmozart\Assert\Assert;

class TrimmedNonEmptyString implements \Stringable
{
    /**
     * @var non-empty-string
     */
    protected readonly string $value;

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(string $value, string $exceptionMessage = '')
    {
        $value = u($value)->trim()->toString();

        Assert::stringNotEmpty($value, $exceptionMessage);
        Assert::notWhitespaceOnly($value, $exceptionMessage);

        $this->value = $value;
    }

    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        return $this->value;
    }

    public static function fromString(string $value, string $exceptionMessage = ''): self
    {
        return new self($value, $exceptionMessage);
    }

    public static function from(mixed $value, string $exceptionMessage = ''): self
    {
        Assert::string($value, $exceptionMessage);

        return self::fromString($value, $exceptionMessage);
    }

    /**
     * @return non-empty-string
     */
    public function toString(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->toString() === $other->toString();
    }

    public function notEquals(self $other): bool
    {
        return !$this->equals($other);
    }
}
