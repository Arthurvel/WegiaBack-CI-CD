<?php

namespace App\Traits;
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
    protected function sucessoResponse($data, string $message = 'Operação realizada com sucesso!', int $statusCode = 200): JsonResponse 
    
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

        // dd($exception);
        
        if ($exception instanceof ModelNotFoundException) {
            $message = 'Não encontrado';
            $status = 404;
        }

        if ($exception instanceof ValidationException) {
            $message = 'Erro de validação';
            $status = 422;
        }

        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null,
        ], $status);
    }
}
