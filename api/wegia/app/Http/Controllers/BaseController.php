<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Traits\Response;
use App\Traits\Validador;
use Illuminate\Routing\Controller;

/**
 * @OA\Info(
 *     title="API Wegia",
 *     version="1.0.0",
 *     description="Documentação da API Wegia"
 * )
 *
* @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     securityScheme="bearerAuth",
 *     bearerFormat="JWT",
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Servidor Local"
 * )
 */

class BaseController extends Controller
{
    use ValidatesRequests, Response, Validador;
}
