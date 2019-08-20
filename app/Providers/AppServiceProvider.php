<?php

namespace App\Providers;

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
            
            $about = About::first();
            $category = Category::where('status',Category::STATUS_ON)->get();     
             $menus = Menu::where('status',Menu::STATUS_ON)->where('parent_id',0)->orderBy('menu_order','asc')->get();
            foreach($menus as $menu)
            {
                $menu->child = Menu::where('status',Menu::STATUS_ON)->where('parent_id',$menu->id)->orderBy('menu_order','asc')->get();
            }                   
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
