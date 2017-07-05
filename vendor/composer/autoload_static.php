<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2dc2e80b96db67f34d3dd8b466b3212c
{
    public static $files = array (
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
        '7d8c19660fc7bda7e3f1bb627c20c455' => __DIR__ . '/..' . '/yooper/stop-words/src/StopWordFactory.php',
        '82b15671fa4352bd2c1ea8902d4c0c5d' => __DIR__ . '/..' . '/yooper/php-text-analysis/src/helpers/storage.php',
        'c2fe535f6d51f069823351f60bd6b280' => __DIR__ . '/..' . '/yooper/php-text-analysis/src/helpers/print.php',
        '34faac671c44560451a381662d8b697c' => __DIR__ . '/..' . '/yooper/php-text-analysis/src/helpers/simplified.php',
        'd64a81d7db4c397f50894b2e5cd69a72' => __DIR__ . '/../..' . '/App.php',
    );

    public static $prefixLengthsPsr4 = array (
        'l' => 
        array (
            'lib\\' => 4,
        ),
        'g' => 
        array (
            'getjump\\Vk\\' => 11,
        ),
        'W' => 
        array (
            'Wamania\\Snowball\\' => 17,
        ),
        'T' => 
        array (
            'TextAnalysis\\' => 13,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Component\\Debug\\' => 24,
            'Symfony\\Component\\Console\\' => 26,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Psr\\Http\\Message\\' => 17,
            'Posts\\' => 6,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
        ),
        'C' => 
        array (
            'Cron\\' => 5,
        ),
        'A' => 
        array (
            'Attachments\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'lib\\' => 
        array (
            0 => __DIR__ . '/../..' . '/lib',
        ),
        'getjump\\Vk\\' => 
        array (
            0 => __DIR__ . '/..' . '/getjump/vk/src/getjump/Vk',
        ),
        'Wamania\\Snowball\\' => 
        array (
            0 => __DIR__ . '/..' . '/wamania/php-stemmer/src',
        ),
        'TextAnalysis\\' => 
        array (
            0 => __DIR__ . '/..' . '/yooper/php-text-analysis/src',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Component\\Debug\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/debug',
        ),
        'Symfony\\Component\\Console\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/console',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Posts\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Posts',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
        'Cron\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Cron',
        ),
        'Attachments\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Attachments',
        ),
    );

    public static $classMap = array (
        'Porter' => __DIR__ . '/..' . '/camspiers/porter-stemmer/src/Porter.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2dc2e80b96db67f34d3dd8b466b3212c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2dc2e80b96db67f34d3dd8b466b3212c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2dc2e80b96db67f34d3dd8b466b3212c::$classMap;

        }, null, ClassLoader::class);
    }
}
