<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Http\Client\RequestException;
use Throwable;

class Handler extends ExceptionHandler
{
	
    public function render($request, Throwable $exception)
    {
		
        // Ошибка поиска модели не работает
		if ($exception instanceof ModelNotFoundException) {
				$model = class_basename($exception->getModel());
				$ids = $exception->getIds();
				$idPart = $ids ? ' с id ' . implode(', ', $ids) : '';

				return response()->json([
					'success' => false,
					'code' => 404,
					'error' => 'model_not_found',
					'message' => "{$model}{$idPart} не найден",
					'details' => null
				], 404);
			}

        // Несуществующий маршрут
        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'success' => false,
                'code' => 404,
                'error' => 'route_not_found',
                'message' => "Маршрут не найден",
                'details' => null
            ], 404);
        }

        // Ошибки валидации
        if ($exception instanceof ValidationException) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'error' => 'validation_error',
                'message' => $exception->getMessage(),
                'details' => $exception->errors()
            ], 422);
        }

        // Ошибки доступа
        if ($exception instanceof AccessDeniedHttpException) {
            return response()->json([
                'success' => false,
                'code' => 403,
                'error' => 'forbidden',
                'message' => "Доступ запрещён",
                'details' => null
            ], 403);
        }
		

        // Все остальные ошибки
        return response()->json([
            'success' => false,
            'code' => 500,
            'error' => 'server_error',
            'message' => $exception->getMessage(),
            'details' => config('app.debug') ? [
                'exception' => class_basename($exception),
                'trace' => $exception->getTrace()
            ] : null
        ], 500);
    }
	
}
