<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Response;
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
        Response::macro('withSuccess', function ($message = "the operation done successfully", $code = 200, array $data = []) {
            return Response()->json(['message' => $message] + ['data' => $data], $code);
        });
        Response::macro('withFailure', function ($message = "something wrong happened", $code = 500, array $data = []) {
            return Response()->json(['message' => $message] + ['data' => $data], $code);
        });
        JsonResource::withoutWrapping();
        Model::unguard();
    }
}
