<?php

declare(strict_types=1);

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
    public function fromString(): void
    {
        $value = self::faker()->word;

        $string = TrimmedNonEmptyString::fromString($value);

        self::assertSame($value, $string->toString());
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
