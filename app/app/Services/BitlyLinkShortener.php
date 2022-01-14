<?php

namespace App\Services;

use \Illuminate\Support\Facades\Http;

class BitlyLinkShortener implements LinkShortener
{
    protected $bitly_token;
    protected $group_guid;

    public function __construct()
    {
        $this->bitly_token = $this->getBitlyToken();
        $this->group_guid = $this->getGroupGuid();
    }

    public function shortenLink(string $link)
    {
        $response = Http::withToken($this->bitly_token)
            ->post('https://api-ssl.bitly.com/v4/shorten',
                [
                    'group_guid' => $this->group_guid,
                    'long_url' => $link
                ]);

        $response->throw();

        return $response['link'];
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
