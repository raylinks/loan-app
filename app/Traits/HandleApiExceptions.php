<?php

namespace App\Traits;

use App\Exceptions\ValidationResponseException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

trait HandleApiExceptions
{
    use Translatable;

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function renderApiResponse($request, Throwable $exception)
    {
        $exception = $this->prepareApiException($exception, $request);

        if ($exception instanceof HttpResponseException) {
            return $exception->getResponse();
        }

        $responseData = $this->composeResponseDataFromException($exception);

        $statusCode = Arr::pull($responseData, 'status_code');
        $headers = $this->isHttpException($exception) ? $exception->getHeaders() : [];

        return response()->json($responseData, $statusCode, $headers);
    }

    /**
     * Prepare exception for rendering.
     *
     * @param \Throwable $exception
     * @param \Illuminate\Http\Request $request
     *
     * @return Throwable
     */
    protected function prepareApiException(Throwable $exception, $request): Throwable
    {
        $exception = $this->prepareException($exception);

        if ($exception instanceof NotFoundHttpException) {
            $message = with($exception->getMessage(), function ($message) {
                return blank($message) || Str::contains($message, 'No query results for model')
                    ? 'Resource not found.' : $message;
            });

            $exception = new HttpException(404, $message, $exception);
        } elseif ($exception instanceof ValidationException) {
            $exception = new ValidationResponseException($exception->validator, $request);
        } elseif ($exception instanceof AuthenticationException) {
            $exception = new HttpException(401, $exception->getMessage(), $exception);
        } elseif ($exception instanceof UnauthorizedException) {
            $exception = new HttpException(403, $exception->getMessage(), $exception);
        }

        return $exception;
    }

    /**
     * Create a response data array based on exception.
     *
     * @param \Throwable $exception
     *
     * @return array
     */
    protected function composeResponseDataFromException(Throwable $exception): array
    {
        $statusCode = $this->isHttpException($exception)
            ? $exception->getStatusCode() : JsonResponse::HTTP_INTERNAL_SERVER_ERROR;

        $responseData = [
            'status_code' => $statusCode,
            'status' => false,
            'message' => $this->getTranslatedMessageFromException($exception),
        ];

        if (config('app.debug') && ! $this->isHttpException($exception)) {
            $responseData = $this->appendDebugData($responseData, $exception);
        }

        return $responseData;
    }

    /**
     * Extract the error message tied to the exception and try to translate it.
     *
     * @param \Throwable $exception
     *
     * @return string
     */
    protected function getTranslatedMessageFromException(Throwable $exception): string
    {
        $message = 'Server error';

        if ($this->isHttpException($exception)) {
            $message = $exception->getMessage() ?: JsonResponse::$statusTexts[$exception->getStatusCode()];
        }

        return (string) Arr::get($this->translateMessageToArray($message), 'message');
    }

    /**
     * Append debug data to the response data returned.
     *
     * @param array $responseData
     * @param \Throwable $exception
     *
     * @return array
     */
    protected function appendDebugData(array $responseData, Throwable $exception): array
    {
        $responseData['error']['_debug'] = [
            'message' => $exception->getMessage(),
            'exception' => get_class($exception),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => collect($exception->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all(),
        ];

        return $responseData;
    }
}
