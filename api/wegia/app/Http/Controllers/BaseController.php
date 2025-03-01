<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Traits\Response;
use Illuminate\Routing\Controller;

/**
 * @OA\Info(
 *     title="API Wegia",
 *     version="1.0.0",
 *     description="Documentação da API Wegia"
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Servidor Local"
 * )
 */

class BaseController extends Controller
{
    use ValidatesRequests, Response;
}
