<?php

namespace Katniss\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;

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

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        logError($exception);

        $response = parent::render($request, $exception);
        if ($request->expectsJson() && $response instanceof JsonResponse) {
            return response()->json([
                '_success' => false,
                '_messages' => [$this->renderMessage($response)],
            ]);
        }

        return $response;
    }

    /**
     * @param JsonResponse $response
     */
    public function renderMessage($response)
    {
        $data = $response->getData(true);
        if (!empty($data['message'])) return $data['message'];

        $rawMessage = 'error_http.' . $response->getStatusCode();
        $message = trans($rawMessage);
        if ($message == $rawMessage) return trans('error.level_3', ['message' => trans('error_http.500')]);
        return trans('error.level_3', ['message' => $message]);
    }
}
