<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4343ede08337a3753deca80cf3359857
{
    public static $prefixLengthsPsr4 = array (
        'O' => 
        array (
            'OpenEMR\\Modules\\Documo\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'OpenEMR\\Modules\\Documo\\' => 
        array (
            0 => __DIR__ . '/../..' . '/controller',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'OpenEMR\\Modules\\Documo\\ApiDispatcher' => __DIR__ . '/../..' . '/controller/ApiDispatcher.php',
        'OpenEMR\\Modules\\Documo\\Database' => __DIR__ . '/../..' . '/controller/Database.php',
        'OpenEMR\\Modules\\Documo\\Provisioning' => __DIR__ . '/../..' . '/controller/Provisioning.php',
        'OpenEMR\\Modules\\Documo\\SendFaxConfig' => __DIR__ . '/../..' . '/controller/SendFaxConfig.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4343ede08337a3753deca80cf3359857::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4343ede08337a3753deca80cf3359857::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4343ede08337a3753deca80cf3359857::$classMap;

        }, null, ClassLoader::class);
    }
}
