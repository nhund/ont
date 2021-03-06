<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 21/08/2019
 * Time: 13:01
 */

namespace App\Providers;

use App\Models\Auth\PassportClient;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot(){
        $this->customRequestHeaderAccessors();
    }

    /**
     * Register custom request macros for accessing custom header.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function customRequestHeaderAccessors()
    {
        $this->accessSpecifiedOAuthClient();
        $this->accessRequestingTimezone();
        $this->accessRequestingMobileClient();
    }

    /**
     * Access requesting timezone via 'Time-Zone' header.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function accessRequestingTimezone()
    {
        $this->app->make('request')->macro('timezone', function () {
            return $this->header('Time-Zone', 'UTC');
        });
    }

    /**
     * Access OAuth client via 'Client-ID' header.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function accessSpecifiedOAuthClient()
    {
        $this->app->make('request')->macro('oauthClient', function () {
            return PassportClient::findOrFail($this->header('OAuth-Client-ID', null));
        });
    }

    /**
     * Access the user agent using 'Mobile-Client' header.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function accessRequestingMobileClient()
    {
        $this->app->make('request')->macro('mobileClient', function () {
            return trim(strtolower($this->header('Mobile-Client', 'web')));
        });

        $this->app->make('request')->macro('isFromWebApp', function () {
            return $this->mobileClient() === 'web';
        });

        $this->app->make('request')->macro('isFromMobileApp', function () {
            return in_array($this->mobileClient(), ['android', 'ios']);
        });
    }
}