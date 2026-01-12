# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a PHP library providing a value object (`TrimmedNonEmptyString`) that ensures strings are both trimmed and non-empty. The library uses:
- `symfony/string` for trimming operations (via `u()` helper)
- `webmozart/assert` for validation
- PHP 8.2+ readonly properties and type declarations

## Architecture

**Single Value Object Pattern**: The entire library consists of one main class `src/TrimmedNonEmptyString.php` that:
- Automatically trims whitespace from input strings using Symfony's Unicode string component
- Validates strings are not empty and not whitespace-only
- Implements `\Stringable` for seamless string conversion
- Provides factory methods: `fromString()` and `from()` (with type checking)
- Supports custom exception messages for validation failures
- Includes equality comparison methods: `equals()` and `notEquals()`
- Uses readonly properties (PHP 8.2+) for immutability

## Development Commands

### Running Tests
```bash
# Run all tests
make test
# or
php vendor/bin/phpunit

# Run specific test
php vendor/bin/phpunit --filter testMethodName

# Run tests with specific configuration
php vendor/bin/phpunit --configuration=phpunit.xml.dist
```

### Code Quality

```bash
# Fix coding standards (PHP CS Fixer with Symfony ruleset)
make cs

# Run static analysis (PHPStan at max level)
make static-code-analysis

# Generate PHPStan baseline
make static-code-analysis-baseline
```

### Composer

```bash
# Validate composer.json
composer validate

# Normalize composer.json
composer normalize
```

## Testing Guidelines

- Uses PHPUnit 10 with PHP attributes (`#[Test]`, `#[DataProvider]`)
- Leverages `ergebnis/data-provider` for common test data (StringProvider, IntProvider, etc.)
- Uses Faker for generating test data (`Factory::create()`)
- Tests should use `assertSame()` for strict comparisons
- All test methods should have the `#[Test]` attribute
- Data providers use `#[DataProviderExternal]` for reusable providers

## Code Style

- PHP CS Fixer with `@Symfony` ruleset
- Strict types declaration required (`declare(strict_types=1);`)
- Header comment required in all files (see `.php-cs-fixer.dist.php`)
- Short array syntax
- Ordered imports and class elements
- PSR-4 autoloading: `OskarStark\Value\` namespace maps to `src/`

## CI Pipeline

GitHub Actions runs on push to main and pull requests:
1. **Coding Standards**: Validates composer.json, checks composer normalize, runs PHP CS Fixer
2. **Static Analysis**: Runs PHPStan with max level
3. **Tests**: Matrix testing across PHP 8.2, 8.3, 8.4, 8.5 with lowest and highest dependencies
