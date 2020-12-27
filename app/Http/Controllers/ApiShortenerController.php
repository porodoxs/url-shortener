<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiShortenerController extends Controller
{
    public function __construct()
    {

    }

    public function getShortUrl(Request $request)
    {
        $url = $request->get('url');

        try {
            $shortUrl = "HfO2g1";

            return response()->json([
                'short_url' => $request->root() . '/' . $shortUrl
            ]);
        } catch (\Throwable $e) {
            return $this->createErrorResponse($e);
        }
    }

    private function createErrorResponse(\Throwable $e)
    {
        return response()->json([
            'code' => 'internal_error',
            'message' => $e->getMessage(),
            'clarification' => [],
        ], 400);
    }
}
