<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf8001af1cd04430cdc23b4df29636c22
{
    public static $prefixLengthsPsr4 = array (
        'Y' => 
        array (
            'YsGroup\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'YsGroup\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf8001af1cd04430cdc23b4df29636c22::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf8001af1cd04430cdc23b4df29636c22::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf8001af1cd04430cdc23b4df29636c22::$classMap;

        }, null, ClassLoader::class);
    }
}
