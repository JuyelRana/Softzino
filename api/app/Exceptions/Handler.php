<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * @param \Exception $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof AuthorizationException && $request->expectsJson()) {
            return response()->json(["errors" => [
                "message" => "You are not authorized to access this resource."
            ]], 403);
        } elseif ($e instanceof ModelNotFoundException && $request->expectsJson()) {
            return response()->json(["errors" => [
                "message" => "The resource was not found in the database."
            ]], 404);
        } elseif ($e instanceof ModelNotDefinedException && $request->expectsJson()) {
            return response()->json(["errors" => [
                "message" => "No model defined."
            ]], 500);
        }

        return parent::render($request, $e);
    }
}
