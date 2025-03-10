<?php

$header = <<<'HEADER'
This file is part of oskarstark/trimmed-non-empty-string.

(c) Oskar Stark <oskarstark@googlemail.com>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
HEADER;

$finder = PhpCsFixer\Finder::create()
    ->in('src')
    ->in('tests')
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'declare_strict_types' => true,
        'header_comment' => [
            'header' => $header,
        ],
        'no_superfluous_phpdoc_tags' => true,
        'no_unused_imports' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'php_unit_test_case_static_method_calls' => true,
        'psr_autoloading' => true,
        'single_line_throw' => false,
    ])
    ->setFinder($finder)
    ->setUsingCache(true)
;
