<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit34a41e2841af1a67f3ddef099fc7b348
{
    public static $files = array (
        '841780ea2e1d6545ea3a253239d59c05' => __DIR__ . '/..' . '/qiniu/php-sdk/src/Qiniu/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        't' => 
        array (
            'think\\composer\\' => 15,
            'think\\' => 6,
        ),
        'a' => 
        array (
            'app\\' => 4,
        ),
        'S' => 
        array (
            'Symfony\\Component\\EventDispatcher\\' => 34,
        ),
        'Q' => 
        array (
            'Qiniu\\' => 6,
        ),
        'O' => 
        array (
            'OSS\\' => 4,
        ),
        'M' => 
        array (
            'MyCLabs\\Enum\\' => 13,
        ),
        'L' => 
        array (
            'Lvht\\' => 5,
        ),
        'G' => 
        array (
            'Grafika\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'think\\composer\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-installer/src',
        ),
        'think\\' => 
        array (
            0 => __DIR__ . '/../..' . '/thinkphp/library/think',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/application',
        ),
        'Symfony\\Component\\EventDispatcher\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/event-dispatcher',
        ),
        'Qiniu\\' => 
        array (
            0 => __DIR__ . '/..' . '/qiniu/php-sdk/src/Qiniu',
        ),
        'OSS\\' => 
        array (
            0 => __DIR__ . '/..' . '/aliyuncs/oss-sdk-php/src/OSS',
        ),
        'MyCLabs\\Enum\\' => 
        array (
            0 => __DIR__ . '/..' . '/myclabs/php-enum/src',
        ),
        'Lvht\\' => 
        array (
            0 => __DIR__ . '/..' . '/lvht/geohash/src',
        ),
        'Grafika\\' => 
        array (
            0 => __DIR__ . '/..' . '/kosinix/grafika/src/Grafika',
        ),
    );

    public static $prefixesPsr0 = array (
        'Q' => 
        array (
            'Qcloud\\Cos\\' => 
            array (
                0 => __DIR__ . '/..' . '/qcloud/cos-sdk-v5/src',
            ),
        ),
        'G' => 
        array (
            'Guzzle\\Tests' => 
            array (
                0 => __DIR__ . '/..' . '/guzzle/guzzle/tests',
            ),
            'Guzzle' => 
            array (
                0 => __DIR__ . '/..' . '/guzzle/guzzle/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit34a41e2841af1a67f3ddef099fc7b348::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit34a41e2841af1a67f3ddef099fc7b348::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit34a41e2841af1a67f3ddef099fc7b348::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
