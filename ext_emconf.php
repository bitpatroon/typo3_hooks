<?php

$EM_CONF[$_EXTKEY] = [
    'title'          => 'Typo3 Hooks',
    'description'    => 'Allows hooks throughout the system',
    'category'       => 'misc',
    'author'         => 'Sjoerd Zonneveld',
    'author_email'   => 'typo3@bitpatroon.nl',
    'state'          => 'stable',
    'author_company' => 'Bitpatroon',
    'version'        => '10.4',
    'constraints'    => [
        'depends' => [
            'typo3' => '10.4.0-10.9.9999',
        ],
    ],
];
