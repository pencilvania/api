<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response as Response;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('success', function ($message = '', $data = null) use ($factory) {
            $format = [
                'status' => 'ok',
                'message' => $message,
                'data' => $data,
            ];

            return $factory->make($format);
        });

        $factory->macro('error', function (string $message = '', $errors = []) use ($factory){
            $format = [
                'status' => 'error',
                'message' => $message,
                'errors' => $errors,
            ];

            return $factory->make($format);
        });

        $factory->macro('validation', function (string $message = '', $errors = []) use ($factory){
            $format = [
                'status' => 'validation_error',
                'message' => $message,
                'validation' => $errors,
            ];
            return $factory->make($format,Response::HTTP_UNPROCESSABLE_ENTITY);
        });
    }
}
