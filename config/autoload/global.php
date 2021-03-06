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

use User\Service\Factory\AuthenticationServiceFactory;
use Zend\Authentication\AuthenticationService;
use Zend\I18n\View\Helper\DateFormat;
use Zend\I18n\View\Helper\Translate;
use Zend\Session\Validator\HttpUserAgent;
use Zend\Session\Validator\RemoteAddr;

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
            'translate' => Translate::class,
            'dateFormat' => DateFormat::class,
        ]
    ],
    
    // Session configuration.
    'session_config' => [
        // Session cookie will expire until browser closed.
        'cookie_lifetime' => 0,
        // Session data will be stored on server maximum for 30 days.
        'gc_maxlifetime'     => 60*60*24*30,
    ],
    // Session manager configuration.
    'session_manager' => [
        // Session validators (used for security).
        'validators' => [
            RemoteAddr::class,
            HttpUserAgent::class,
        ]
    ],
    // Session storage configuration.
    'session_storage' => [
        'type' => SessionArrayStorage::class
    ],
    
    'service_manager' => [
        'factories' => [
            AuthenticationService::class
            => AuthenticationServiceFactory::class,
        ],
    ],
];
