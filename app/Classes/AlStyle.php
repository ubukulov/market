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

    public function getProducts($offset = 0)
    {
        $client = new Client(['base_uri' => env('AL_STYLE_API')]);
        $response = $client->request('GET', 'elements?access-token=' . env('AL_STYLE_TOKEN') . '&limit=250&offset=' . $offset);
        return $response->getBody()->getContents();
    }

    public function getProductInfo($article)
    {
        $client = new Client(['base_uri' => env('AL_STYLE_API')]);
        $response = $client->request('GET', 'images?access-token=' . env('AL_STYLE_TOKEN') . '&article=' . $article);

        $arrImages = [];

        $result = $response->getBody()->getContents();
        $result = (array) json_decode($result);
        $arrImages['images'] = $result[$article];

        $response = $client->request('GET', 'images?access-token=' . env('AL_STYLE_TOKEN') . '&article=' . $article . '&thumbs=1');

        $result = $response->getBody()->getContents();
        $result = (array) json_decode($result);
        $arrImages['thumbs'] = $result[$article];

        return $arrImages;
    }

    public function getProductFeature($article)
    {
        $client = new Client(['base_uri' => env('AL_STYLE_API')]);
        $params = [
            'description',
            'brand',
            'weight',
            'warranty',
            'barcode',
            'reducedprice',
            'expectedArrivalDate',
            'detailtext',
            'properties',
        ];

        $response = $client->request('GET', 'element-info?access-token=' . env('AL_STYLE_TOKEN') . '&article=' . $article . '&additional_fields=' . implode(",", $params));

        return json_decode($response->getBody()->getContents());
    }

    public function getProductPriceAndQuantity($article)
    {
        $client = new Client(['base_uri' => env('AL_STYLE_API')]);
        $response = $client->request('GET', 'quantity-price?access-token=' . env('AL_STYLE_TOKEN') . '&article=' . $article);

        $result = json_decode($response->getBody()->getContents());
        return (array) $result;
    }
}
