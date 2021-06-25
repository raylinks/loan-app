<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\HandleApiExceptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use HandleApiExceptions {
        HandleApiExceptions::prepareApiException as prepApiException;
    }
    
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
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

     /**
     * Report or log an exception.
     *
     * @param \Throwable $exception
     *
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        if (
            app()->environment('production') &&
            app()->bound('sentry') &&
            $this->shouldReport($exception)
        ) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        return $this->renderApiResponse($request, $exception);
    }

    /**
     * Prepare exception for API response rendering.
     *
     * @param \Throwable $exception
     * @param \Illuminate\Http\Request $request
     *
     * @return \Throwable
     */
    protected function prepareApiException(Throwable $exception, $request): Throwable
    {
        return $this->prepApiException($exception, $request);
    }

}
