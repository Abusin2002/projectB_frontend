<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        // JWT token expired
        $this->renderable(function (TokenExpiredException $e, $request) {
            return response()->json(['status' => 'error', 'message' => 'Token has expired'], 401);
        });

        // JWT token invalid
        $this->renderable(function (TokenInvalidException $e, $request) {
            return response()->json(['status' => 'error', 'message' => 'Token is invalid'], 401);
        });

        // JWT token missing
        $this->renderable(function (JWTException $e, $request) {
            return response()->json(['status' => 'error', 'message' => 'Token not provided'], 401);
        });
    }

    /**
     * Handle Laravel authentication failures (non-JWT).
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? response()->json(['status' => 'error', 'message' => 'You are not logged in.'], 401)
            : redirect()->guest(route('login'));
    }
}
