<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class BaseController extends Controller
{
    protected $data = null;

    /**
     * @param $route
     * @return RedirectResponse
     */
    protected function responseRedirect($route)
    {
        return redirect()->route($route);
    }

    /**
     * @param bool $success
     * @param int $responseCode
     * @param null $data
     * @return JsonResponse
     */
    protected function responseJson($success = true, $responseCode = 200, $data = null)
    {
        return response()->json([
            'success' => $success,
            'data' => $data
        ], $responseCode);
    }

    /**
     * @param $errors
     * @return JsonResponse
     */
    protected function responseValidationErrorJson($errors)
    {
        return response()->json([
            'success' => false,
            'errors' => $errors
        ], 404);
    }

    /**
     * @return JsonResponse
     */
    protected function responseSuccessJson()
    {
        return response()->json([
            'success' => true
        ], 200);
    }

    /**
     * @return JsonResponse
     */
    protected function responseCreatedJson()
    {
        return response()->json([
            'success' => true
        ], 201);
    }

    /**
     * @return JsonResponse
     */
    protected function responseUpdatedJson()
    {
        return response()->json([
            'success' => true
        ], 204);
    }
}
