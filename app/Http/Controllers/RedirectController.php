<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RedirectController extends Controller
{
    /*
     * Redirect to the original URL
     */
    public function __invoke(string $code): RedirectResponse
    {
        $url = Url::where('short_code', $code)->first();

        if (!$url) {
            throw new NotFoundHttpException('URL not found');
        }

        $url->incrementAccessCount();

        return redirect($url->original_url);
    }
}
