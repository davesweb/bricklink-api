<?php

$finder =
    PhpCsFixer\Finder::create()
    ->in([__DIR__ . '/src', __DIR__ . '/tests'])
;

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@PSR12' => true,
    '@PhpCsFixer' => true,
    'strict_param' => true,
    'array_syntax' => ['syntax' => 'short'],
    'ordered_imports' => ['sort_algorithm' => 'length'],
    'binary_operator_spaces' => ['default' => 'align']
])->setFinder($finder);