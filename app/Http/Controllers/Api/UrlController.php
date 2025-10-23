<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUrlRequest;
use App\Models\Url;
use Illuminate\Http\JsonResponse;

class UrlController extends Controller
{
    /*
     * Create a new shortened URL
     */
    public function store(CreateUrlRequest $request): JsonResponse
    {
        $url = Url::create([
            'original_url' => $request->original_url,
            'short_code' => Url::generateShortCode(),
        ]);

        return response()->json([
            'short_url' => $url->short_url,
            'original_url' => $url->original_url,
            'short_code' => $url->short_code,
        ], 201);
    }

    /*
     * List all shortened URLs
     */
    public function index(): JsonResponse
    {
        $urls = Url::orderBy('created_at', 'desc')->get();

        return response()->json([
            'data' => $urls->map(function ($url) {
                return [
                    'id' => $url->id,
                    'original_url' => $url->original_url,
                    'short_url' => $url->short_url,
                    'short_code' => $url->short_code,
                    'access_count' => $url->access_count,
                    'created_at' => $url->created_at->toIso8601String(),
                ];
            }),
        ]);
    }
}
