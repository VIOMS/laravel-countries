<?php
namespace Vioms\Countries;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // The publication files to publish
        $this->publishes([
            __DIR__ . '/../resources/config' => config_path()
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/database/migrations/' => database_path('migrations')
        ], 'migrations');


        $this->publishes([
            __DIR__ . '/../resources/assets/' => public_path('assets')
        ], 'assets');

        /**
         * LEGACY SUPPORT
         */
        $seedersFolder = (is_dir(database_path('seeders')) ? 'seeders' : 'seeds');
        $this->publishes([
            __DIR__ . '/../resources/database/seeders/' => database_path($seedersFolder)
        ], 'seeders');



        // Append the country settings
        $this->mergeConfigFrom(
            __DIR__ . '/../resources/config/countries.php', 'countries'
        );
    }

    /**
     * Register everything.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCountries();
        $this->registerHelpers();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registerCountries()
    {
        $this->app->bind('countries', function($app)
        {
            return new \Vioms\Countries\Models\Country();
        });
    }

    /**
     * Register the artisan commands.
     *
     * @return void
     */
    protected function registerHelpers()
    {
        require_once __DIR__ . '/Helpers/CountryImage.php';
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['countries'];
    }

}
