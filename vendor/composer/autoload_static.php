<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2bfb9cc5ef0289a0d00b19300e5e3904
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WPP\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WPP\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2bfb9cc5ef0289a0d00b19300e5e3904::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2bfb9cc5ef0289a0d00b19300e5e3904::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2bfb9cc5ef0289a0d00b19300e5e3904::$classMap;

        }, null, ClassLoader::class);
    }
}