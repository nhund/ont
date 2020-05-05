<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\About;
use App\Models\Category;
use App\Models\Menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('*', function($view) {

			$about = Cache::remember('menu_about', 3600, function () {
				return About::first();
			});

			$category = Cache::remember('menu_category', 3600, function () {
				return Category::where('status', Category::STATUS_ON)->get();
			});

			$menus = Cache::remember('menu_menus', 3600, function () {
				$menu = Menu::where('status', Menu::STATUS_ON)->where('parent_id', 0)->orderBy('menu_order', 'asc')->get();

				foreach ($menu as $men) {
					$men->child = Menu::where('status', Menu::STATUS_ON)->where('parent_id', $men->id)->orderBy('menu_order', 'asc')->get();
				}
				return $menu;
			});
            $view->with('data_all', compact('about','category','menus'));
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
