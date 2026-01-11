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

namespace OskarStark\Value\Tests;

use Ergebnis\Test\Util\DataProvider\BoolProvider;
use Ergebnis\Test\Util\DataProvider\FloatProvider;
use Ergebnis\Test\Util\DataProvider\IntProvider;
use Ergebnis\Test\Util\DataProvider\NullProvider;
use Ergebnis\Test\Util\DataProvider\ObjectProvider;
use Ergebnis\Test\Util\DataProvider\StringProvider;
use Ergebnis\Test\Util\Helper;
use OskarStark\Value\TrimmedNonEmptyString;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class TrimmedNonEmptyStringTest extends TestCase
{
    use Helper;

    #[Test]
    public function constructor(): void
    {
        $value = self::faker()->word;

        $string = new TrimmedNonEmptyString($value);

        static::assertSame($value, $string->toString());
        static::assertSame($value, (string) $string);
    }

    #[Test]
    public function constructorThrowsCustomExceptionMessage(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('foo');

        new TrimmedNonEmptyString('', 'foo');
    }

    #[Test]
    public function from(): void
    {
        $value = self::faker()->word;

        $string = TrimmedNonEmptyString::from($value);

        static::assertSame($value, $string->toString());
        static::assertSame($value, (string) $string);
    }

    #[Test]
    public function fromThrowsCustomExceptionMessage(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('foo');

        TrimmedNonEmptyString::from('', 'foo');
    }

    #[Test]
    public function fromString(): void
    {
        $value = self::faker()->word;

        $string = TrimmedNonEmptyString::fromString($value);

        static::assertSame($value, $string->toString());
        static::assertSame($value, (string) $string);
    }

    #[Test]
    public function fromStringThrowsCustomExceptionMessage(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('foo');

        TrimmedNonEmptyString::fromString('', 'foo');
    }

    #[Test]
    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    #[DataProviderExternal(IntProvider::class, 'arbitrary')]
    #[DataProviderExternal(NullProvider::class, 'null')]
    #[DataProviderExternal(ObjectProvider::class, 'object')]
    #[DataProviderExternal(BoolProvider::class, 'arbitrary')]
    #[DataProviderExternal(FloatProvider::class, 'arbitrary')]
    public function fromThrowsInvalidArgumentExceptionWithValue(mixed $value): void
    {
        $this->expectException(\InvalidArgumentException::class);

        TrimmedNonEmptyString::from($value);
    }

    #[Test]
    #[DataProviderExternal(StringProvider::class, 'blank')]
    #[DataProviderExternal(StringProvider::class, 'empty')]
    public function fromStringThrowsInvalidArgumentExceptionWithValue(string $value): void
    {
        $this->expectException(\InvalidArgumentException::class);

        TrimmedNonEmptyString::fromString($value);
    }

    /**
     * @return \Generator<string, array{TrimmedNonEmptyString, TrimmedNonEmptyString, bool}>
     */
    public static function provideEqualsData(): \Generator
    {
        $value = 'test';

        yield 'same value' => [
            new TrimmedNonEmptyString($value),
            new TrimmedNonEmptyString($value),
            true,
        ];

        yield 'values that trim to same' => [
            new TrimmedNonEmptyString($value),
            new TrimmedNonEmptyString('  '.$value.'  '),
            true,
        ];

        yield 'different values' => [
            new TrimmedNonEmptyString('foo'),
            new TrimmedNonEmptyString('bar'),
            false,
        ];

        yield 'extended class with same value' => [
            new class($value) extends TrimmedNonEmptyString {},
            new class($value) extends TrimmedNonEmptyString {},
            true,
        ];

        yield 'extended class with different values' => [
            new class('foo') extends TrimmedNonEmptyString {},
            new class('bar') extends TrimmedNonEmptyString {},
            false,
        ];

        yield 'base and extended class with same value' => [
            new TrimmedNonEmptyString($value),
            new class($value) extends TrimmedNonEmptyString {},
            true,
        ];
    }

    #[Test]
    #[DataProvider('provideEqualsData')]
    public function equals(TrimmedNonEmptyString $string1, TrimmedNonEmptyString $string2, bool $expected): void
    {
        static::assertSame($expected, $string1->equals($string2));
    }

    #[Test]
    #[DataProvider('provideEqualsData')]
    public function notEquals(TrimmedNonEmptyString $string1, TrimmedNonEmptyString $string2, bool $expected): void
    {
        static::assertSame(!$expected, $string1->notEquals($string2));
    }
}
