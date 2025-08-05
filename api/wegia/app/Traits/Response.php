<?php

namespace App\Traits;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

trait Response
{

    /**
     * Retorna uma resposta de sucesso padrão.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
    */
    protected function sucessoResponse($data, int $statusCode = 200,  string $message = 'Operação realizada com sucesso!'): JsonResponse

    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Retorna uma resposta de erro padrão.
     *
     * @param \Exception $exception
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function errorResponse(\Exception $exception = null, int $statusCode = 400, string $messageError = 'Ocorreu um erro na operação!'): JsonResponse
    {
        $status = $statusCode;
        $message = $messageError;

        if ($exception instanceof ModelNotFoundException) {
            $message = 'Não encontrado';
            $status = 404;
        }

        if ($exception instanceof ValidationException) {
            $message = $exception->validator->getMessageBag()->getMessages();
            $status = 422;
        }

        if($exception instanceof AuthorizationException) {
            $message = $exception->getMessage();
            $status = 403;
        }

        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null,
        ], $status);
    }
}
