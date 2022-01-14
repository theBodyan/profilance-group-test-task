<?php

namespace App\Services;

interface LinkShortener
{
    public function shortenLink(string $link);
}
