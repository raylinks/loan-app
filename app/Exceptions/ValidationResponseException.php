<?php

namespace App\Exceptions;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ValidationResponseException extends HttpResponseException
{
    public int $statusCode = 422;

    protected Validator $validator;

    protected Request $request;

    public function __construct(Validator $validator, Request $request = null)
    {
        $this->validator = $validator;
        $this->request = $request ?? request();

        parent::__construct(
            response()->json($this->getResponseData(), $this->statusCode)
        );
    }

    /**
     * Prepare the response data.
     *
     * @return array
     */
    protected function getResponseData(): array
    {
        return [
            'status' => false,
            'message' => 'Validation error occurred.',
            'errors' => $this->validationErrorData(),
        ];
    }

    /**
     * Format the validation error messages to also include the rejected values as well as the messages.
     */
    protected function validationErrorData(): array
    {
        $normalizedMessages = array_unique(
            Arr::dot($this->validator->errors()->getMessages())
        );

        $result = collect([]);

        collect($normalizedMessages)->each(function ($message, $key) use (&$result) {
            $field = substr($key, 0, strpos($key, '.'));

            if (! $result->has($field)) {
                $result = $result->put($field, [
                    'message' => $message,
                    'rejected_value' => $this->request->input($field),
                ]);
            }
        });

        return $result->all();
    }

    /**
     * Get exception validator.
     */
    public function getValidator(): Validator
    {
        return $this->validator;
    }

    /**
     * Get exception request.
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}
