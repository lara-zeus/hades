<?php

namespace LaraZeus\Hades;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class HadesServiceProvider extends PackageServiceProvider
{
    public static string $name = 'zeus-hades';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name);
    }
}
