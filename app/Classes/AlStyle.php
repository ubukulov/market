<?php


namespace App\Classes;

use GuzzleHttp\Client;

class AlStyle
{
    public function getCategories()
    {
        $client = new Client(['base_uri' => env('AL_STYLE_API')]);
        $response = $client->request('GET', 'categories?access-token=' . env('AL_STYLE_TOKEN'));

        return $response->getBody()->getContents();
    }
}
