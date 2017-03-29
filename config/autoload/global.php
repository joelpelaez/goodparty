<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

use Zend\I18n\View\Helper\Translate;

return [
    // ...
    'translator' => [
        'locale' => 'es',
        'translation_file_patterns' => [
            [
                'type'     => 'phparray',
                'base_dir' => getcwd() . '/data/language',
                'pattern'  => '%s.php',
            ],
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'translate' => Translate::class
        ]
    ],
];