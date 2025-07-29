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
}
