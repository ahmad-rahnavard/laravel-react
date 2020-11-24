<?php

namespace App\Providers;

use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro(
            'success',
            fn(string $message = 'success!', array $data = [], int $statusCode = 200) => response()->json([
                'code'    => $statusCode,
                'message' => $message,
                'data'    => $data
            ], $statusCode));

        Response::macro(
            'error',
            fn(string $message = 'error!', array $errors = [], int $statusCode = 400) => response()->json([
                'code'    => $statusCode,
                'message' => $message,
                'errors'  => $errors
            ], $statusCode));
    }
}
