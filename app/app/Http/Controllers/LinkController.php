<?php

namespace App\Http\Controllers;

use App\Services\BitlyLinkShortener;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class LinkController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function shortenLink(Request $request) : JsonResponse
    {
        $full_link = $request->input('link');

        $short_link = (new BitlyLinkShortener())->shortenLink($full_link);

        return response()->json(
            [
                'full_link' => $full_link,
                'short_link' => $short_link,
                'message' => 'Link was shortened successfully!'
            ],
            200);
    }
}
