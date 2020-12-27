<?php

namespace App\Http\Controllers;

use App\Shorteners\Shorteners\ShortenersHandler;
use Illuminate\Http\Request;

class ApiShortenerController extends Controller
{
    private $shortenersHandler;

    public function __construct(ShortenersHandler $shortenersHandler)
    {
        $this->shortenersHandler = $shortenersHandler;
    }

    public function getShortUrl(Request $request)
    {
        $url = $request->get('url');

        try {
            $shortUrl = $this->shortenersHandler->getShortUrl($url);

            return response()->json([
                'short_url' => $request->root() . '/' . $shortUrl['short_url']
            ]);
        } catch (\Throwable $e) {
            return $this->createErrorResponse($e);
        }
    }

    public function handleShortUrl(string $shortUrl)
    {
        $shortUrl = trim($shortUrl);

        try {
            $originalUrl = $this->shortenersHandler->getOriginalUrl($shortUrl);

            return redirect()->to($originalUrl);
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
