<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('config')
    ->exclude('public')
    ->exclude('migrations')
    ->exclude('node_modules')
    ->exclude('data')
    ->exclude('var')
    // exclude files generated by Symfony Flex recipes
    ->notPath('bin/console')
    ->notPath('public/index.php')
    ->notPath('src/Kernel.php')
    ->notPath('tests/bootstrap.php')
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@DoctrineAnnotation' => true,
        '@PhpCsFixer' => true,
        '@PHP81Migration' => true,
        '@Symfony' => true,
        'concat_space' => ['spacing' => 'one'],
        'global_namespace_import' => true,
        'mb_str_functions' => true,
        'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false],
        // risky
        'no_php4_constructor' => true,
        'strict_comparison' => true,
    ])
//        'no_unreachable_default_argument_value' => true,
//        '@PhpCsFixer:risky' => true,
//        '@PHP80Migration:risky' => true,
//        '@Symfony:risky' => true,
//        'strict_param' => true,

    ->setFinder($finder)
    ->setCacheFile(__DIR__ . '/var/.php-cs-fixer.cache') // forward compatibility with 3.x line
;
