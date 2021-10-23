<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . "/app/")
    ->in(__DIR__ . "/tests/")
    ->in(__DIR__ . "/database/")
    ->in(__DIR__ . "/routes/");

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12' => true,
    'declare_strict_types' => true,
])->setFinder($finder);
