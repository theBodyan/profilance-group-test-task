<?php

namespace App\Http\Controllers;

use \Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

final class LinkController extends Controller
{
    protected $bitly_token;
    protected $group_guid;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->bitly_token = $this->getBitlyToken();
        $this->group_guid = $this->getGroupGuid();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function shortenLink(Request $request)
    {
        $original_link = $request->input('link');

        $response = Http::withToken($this->bitly_token)
            ->post('https://api-ssl.bitly.com/v4/shorten',
                [
                    'group_guid' => $this->group_guid,
                    'long_url' => $original_link
                ]);

        $response->throw();

        return response()->json(
            [
                'short_link' => $response['link'],
                'message' => 'Link was shortened successfully!'
            ],
            200);
    }

    private function getGroupGuid(): string
    {
        $response = Http::withToken($this->getBitlyToken())
            ->get('https://api-ssl.bitly.com/v4/groups');

        $response->throw();

        return $response['groups'][0]['guid'];
    }

    private function getBitlyToken(): string
    {
        return getenv('BITLY_API_TOKEN');
    }
}
