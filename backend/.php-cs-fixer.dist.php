<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database/factories',
        __DIR__ . '/database/seeders',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ]);

$config = new PhpCsFixer\Config();

return $config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PhpCsFixer:risky' => true,
        'blank_line_after_opening_tag' => true,
        'linebreak_after_opening_tag' => true,
        'declare_strict_types' => true,
        'no_superfluous_phpdoc_tags' => false,
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => true,
        ],
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => [
                'class',
                'function',
                'const',
            ],
        ],
        'no_unused_imports' => true,
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_last',
            'sort_algorithm' => 'none',
        ],
        'php_unit_test_case_static_method_calls' => [
            'call_type' => 'this'
        ],
        'phpdoc_align' => [
            'align' => 'left',
        ],
        'not_operator_with_successor_space' => true,
        'blank_line_after_namespace' => true,
        'final_class' => true,
        'date_time_immutable' => true,
        'declare_parentheses' => true,
        'final_public_method_for_abstract_class' => true,
        'mb_str_functions' => true,
        'simplified_if_return' => true,
        'simplified_null_return' => true,
    ])
    ->setFinder($finder);