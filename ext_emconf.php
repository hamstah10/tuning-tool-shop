<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Tuning Tool Shop',
    'description' => 'Shop Extension für Chiptuning Geräte und Zubehör',
    'category' => 'plugin',
    'author' => 'Hamstahstudio',
    'author_email' => '',
    'state' => 'stable',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
            'nnrestapi' => '13.0.0-13.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
