<?php

namespace App\Providers;

use App\Modules\Core\Article;
use App\Modules\Editor\Article\Observers\ArticleObserver;
use App\Modules\User\Observers\UserObserver;
use App\Modules\Core\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        Article::observe(ArticleObserver::class);
        User::observe(UserObserver::class);
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
