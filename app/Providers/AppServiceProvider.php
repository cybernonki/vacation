<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'local') {
            // SQLログ出力
            DB::listen(function ($query) {
                $sql = $query->sql;
                for ($i = 0; $i < count($query->bindings); $i++) {
                    $sql = preg_replace("/\?/", $query->bindings[$i], $sql, 1);
                }
                Log::info("Query Time:{$query->time}s sql={". $sql ."}");
            });
        }
        // custom Paginator追加
        Paginator::useBootstrap();
    }
}
