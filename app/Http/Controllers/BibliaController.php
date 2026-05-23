<?php

namespace App\Http\Controllers;

use App\Services\BibliaApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BibliaController extends Controller
{
    public function versiculoDoDia(BibliaApiService $bibliaApi): JsonResponse
    {
        $versiculo = $bibliaApi->versiculoDoDia();

        return response()->json($versiculo);
    }
}
