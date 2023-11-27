<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Throwable;
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
        //This part will handle ThrottleRequestsException exceptions
//        $this->renderable(function (ThrottleRequestsException $e, $request) {
//
//                return response()->json([
//                    'message' => 'To many requests you can try again in ' . $e->getHeaders()['Retry-After'] . ' seconds'
//                ], 429);
//
//        });

        $this->renderable(function (ThrottleRequestsException $e, $request) {
            $retryAfter = $e->getHeaders()['Retry-After'];

            $message = 'Too many requests.';

            // Check the time interval and customize the message accordingly
            if ($retryAfter <= 60) {
                $message .= ' Please try again in ' . $retryAfter . ' seconds.';
            } elseif ($retryAfter <= 3600) {
                $message .= ' Please try again in ' . round($retryAfter / 60) . ' minutes.';
            } else {
                $message .= ' Please try again in ' . round($retryAfter / 3600) . ' hours.';
            }

            return response()->json(['message' => $message], 429);
        });
    }

}
