<?php

namespace App\Exceptions;

use GuzzleHttp\Exception\ServerException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function register()
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->expectsJson()) {
                return api(false, 404, $e->getMessage())->get();
            }
        });
        $this->renderable(function (AuthorizationException $e, $request) {
            if ($request->expectsJson()) {
                return api(false, 401, $e->getMessage())->get();
            }
        });
        $this->renderable(function (ServerException $e, $request) {
            if ($request->expectsJson()) {
                return api(false, 500, $e->getMessage())->get();
            }
        });
        $this->renderable(function (ModelNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                return api(false, 404, $e->getMessage())->get();
            }
        });
        $this->renderable(function (RouteNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                return api(false, 404, $e->getMessage())->get();
            }
        });
        $this->renderable(function (\HttpException $e, $request) {
            if ($request->expectsJson()) {
                return api(false, 405, $e->getMessage())->get();
            }
        });
        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->expectsJson()) {
                return api(false, 405, $e->getMessage())->get();
            }
        });
        $this->renderable(function (\Exception $e, $request) {
            if ($request->expectsJson()) {
                return api(false, 500, $e->getMessage())->get();
            }
        });
    }
}
