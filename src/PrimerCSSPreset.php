<?php
namespace LaravelFrontendPresets\PrimerCSSPreset;

use Artisan;
use Illuminate\Support\Arr;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\Presets\Preset;

class PrimerCSSPreset extends Preset
{
    /**
     * Install the preset.
     *
     * @return void
     */
    public static function install()
    {
        static::updatePackages();
        static::updateSass();
        static::removeNodeModules();
    }

    /**
     * Update the given package array.
     *
     * @param  array  $packages
     * @return array
     */
    protected static function updatePackageArray(array $packages)
    {
        return [
            'primer-css' => '^9.0.0',
        ] + Arr::except($packages, ['bootstrap-sass', 'foundation-sites', 'uikit']);
    }

    /**
     * Update the Sass files for the application.
     *
     * @return void
     */
    protected static function updateSass()
    {
        // clean up orphan files
        $orphan_sass_files = glob(resource_path('/assets/sass/*.*'));

        foreach($orphan_sass_files as $sass_file)
        {
            (new Filesystem)->delete($sass_file);
        }

        copy(__DIR__.'/primercss-stubs/primercss.sass', resource_path('assets/sass/primercss.sass'));
        copy(__DIR__.'/primercss-stubs/app.scss', resource_path('assets/sass/app.scss'));
    }
}
