<?php

namespace Aijoh\Core;

use Aijoh\Core\Commands\CoreCommand;
use Aijoh\Core\Macro\MixIn\StringableMixin;
use Aijoh\Core\Macro\MixIn\StrMixin;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CoreServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('core')
     //       ->hasConfigFile()
     //       ->hasViews()
            ->hasMigration('create_prefecture_table')
            ->hasCommand(CoreCommand::class);

    }

    public function boot()
    {
        Str::mixin(new StrMixin);
        Stringable::mixin(new StringableMixin);
    }
}
