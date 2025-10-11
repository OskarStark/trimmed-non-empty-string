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

use Ergebnis\Test\Util\Helper;
use OskarStark\Value\TrimmedNonEmptyString;
use PHPUnit\Framework\TestCase;

final class TrimmedNonEmptyStringTest extends TestCase
{
    use Helper;

    /**
     * @test
     */
    public function constructor(): void
    {
        $value = self::faker()->word;

        $string = new TrimmedNonEmptyString($value);

        static::assertSame($value, $string->toString());
        static::assertSame($value, (string) $string);
    }

    /**
     * @test
     */
    public function constructorThrowsCustomExceptionMessage(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('foo');

        new TrimmedNonEmptyString('', 'foo');
    }

    /**
     * @test
     */
    public function from(): void
    {
        $value = self::faker()->word;

        $string = TrimmedNonEmptyString::from($value);

        static::assertSame($value, $string->toString());
        static::assertSame($value, (string) $string);
    }

    /**
     * @test
     */
    public function fromThrowsCustomExceptionMessage(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('foo');

        TrimmedNonEmptyString::from('', 'foo');
    }

    /**
     * @test
     */
    public function fromString(): void
    {
        $value = self::faker()->word;

        $string = TrimmedNonEmptyString::fromString($value);

        static::assertSame($value, $string->toString());
        static::assertSame($value, (string) $string);
    }

    /**
     * @test
     */
    public function fromStringThrowsCustomExceptionMessage(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('foo');

        TrimmedNonEmptyString::fromString('', 'foo');
    }

    /**
     * @test
     *
     * @dataProvider \Ergebnis\Test\Util\DataProvider\StringProvider::blank()
     * @dataProvider \Ergebnis\Test\Util\DataProvider\StringProvider::empty()
     * @dataProvider \Ergebnis\Test\Util\DataProvider\IntProvider::arbitrary()
     * @dataProvider \Ergebnis\Test\Util\DataProvider\NullProvider::null()
     * @dataProvider \Ergebnis\Test\Util\DataProvider\ObjectProvider::object()
     * @dataProvider \Ergebnis\Test\Util\DataProvider\BoolProvider::arbitrary()
     * @dataProvider \Ergebnis\Test\Util\DataProvider\FloatProvider::arbitrary()
     */
    public function fromThrowsInvalidArgumentExceptionWithValue(mixed $value): void
    {
        $this->expectException(\InvalidArgumentException::class);

        TrimmedNonEmptyString::from($value);
    }

    /**
     * @test
     *
     * @dataProvider \Ergebnis\Test\Util\DataProvider\StringProvider::blank()
     * @dataProvider \Ergebnis\Test\Util\DataProvider\StringProvider::empty()
     */
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
            new TrimmedNonEmptyString('  ' . $value . '  '),
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

    /**
     * @test
     *
     * @dataProvider provideEqualsData
     */
    public function equals(TrimmedNonEmptyString $string1, TrimmedNonEmptyString $string2, bool $expected): void
    {
        static::assertSame($expected, $string1->equals($string2));
    }

    /**
     * @test
     *
     * @dataProvider provideEqualsData
     */
    public function notEquals(TrimmedNonEmptyString $string1, TrimmedNonEmptyString $string2, bool $expected): void
    {
        static::assertSame(!$expected, $string1->notEquals($string2));
    }
}
