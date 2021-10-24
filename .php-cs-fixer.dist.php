<?php

$finder = PhpCsFixer\Finder::create()
    ->notPath(
        [
            'Unit/BusinessDomain/Fiuselist/Service/FiuselistEntryEntityServiceTest.php',
            'Integration/Controller/ContentControllerTest.php'
        ]
    )
    ->in(
        [
            __DIR__ . "/app/",
            __DIR__ . "/tests/",
            __DIR__ . "/database/",
            __DIR__ . "/routes/",
        ]
    );

$config = new PhpCsFixer\Config();
return $config->setRules([
    '@PSR12' => true,
    '@PhpCsFixer:risky' => true,
    'declare_strict_types' => true,
])->setFinder($finder);
