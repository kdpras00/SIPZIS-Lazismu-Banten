<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Auth;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Handle 404 errors
        $this->renderable(function (NotFoundHttpException $e, $request) {
            // For admin routes, redirect to login if not authenticated
            if ($request->is('admin/*')) {
                if (!Auth::check()) {
                    return redirect()->route('login');
                }
            }

            // For all other 404 errors, show custom 404 page
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Not Found'], 404);
            }

            // Return the 404 view
            return response()->view('errors.404', [], 404);
        });
    }
}
