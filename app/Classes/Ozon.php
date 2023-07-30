<?php


namespace App\Classes;

use App\Models\MarketPlace;
use App\Models\UserMarketplaceSetting;
use GuzzleHttp\Client;
use Style;
use Auth;

class Ozon
{
    protected $clientId = '';
    protected $api = '';
    protected $token = '';

    public function __construct($user_id)
    {
        if($this->clientId == '' || $this->token == '' || $this->api == '') {

            $marketplace = MarketPlace::where(['slug' => 'ozon'])->first();

            if(!$marketplace) {
                abort(500, 'В таблице marketplaces отсутствует запись про Ozon');
            }

            $marketplace_setting = UserMarketplaceSetting::where(['user_id' => $user_id, 'marketplace_id' => $marketplace->id])->first();
            if(!$marketplace_setting) {
                abort(500, 'У пользователя нет данные о маркетплейсе');
            }

            $this->clientId     = $marketplace_setting->client_id;
            $this->api          = $marketplace_setting->api;
            $this->token        = $marketplace_setting->client_secret;
        }
    }

    public function getCategories()
    {
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'v2/category/tree', [
            'headers' => [
                'Content-type' => 'application/json',
                'Client-Id' => $this->clientId,
                'Api-Key' => $this->token
            ],
        ]);

        return $request->getBody()->getContents();
    }

    public function createOrUpdate($data)
    {
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'v2/product/import', [
            'headers' => [
                'Content-type' => 'application/json',
                'Client-Id' => $this->clientId,
                'Api-Key' => $this->token
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        return $request->getBody()->getContents();
    }

    public function getCategoryAttributes($category_id)
    {
        $data = [
            'attribute_type' => 'ALL',
            'category_id'    => [$category_id],
            'language' => 'DEFAULT'
        ];
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'v3/category/attribute', [
            'headers' => [
                'Content-type' => 'application/json',
                'Client-Id' => $this->clientId,
                'Api-Key' => $this->token
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        if($request->getStatusCode() === 200) {
            return $request->getBody()->getContents();
        }

        return false;
    }

    /**
     * Метод проверен. Успешно обновляет картинки. Передать в запросе список картинок в виде массива
     * и передат ид продукта (в ОЗОНЕ)
     * @return bool|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateProductPictures()
    {
        $data = [
            'color_image' => 'string',
            'images'    => [
                "https://img.al-style.kz/34061_1.jpg",
                "https://img.al-style.kz/34061_2.jpg",
                "https://img.al-style.kz/34061_3.jpg"
            ],
            'images360' => [
                "https://img.al-style.kz/34061_01.jpg"
            ],
            'product_id' => 355006627
        ];

        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'v1/product/pictures/import', [
            'headers' => [
                'Content-type' => 'application/json',
                'Client-Id' => $this->clientId,
                'Api-Key' => $this->token
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        if($request->getStatusCode() === 200) {
            return $request->getBody()->getContents();
        }

        return false;
    }

    public function updateStocks($data)
    {
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'v1/product/import/stocks', [
            'headers' => [
                'Content-type' => 'application/json',
                'Client-Id' => $this->clientId,
                'Api-Key' => $this->token
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        if($request->getStatusCode() === 200) {
            return json_decode($request->getBody()->getContents());
        }

        return false;
    }

    public function updatePrices($data)
    {
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'v1/product/import/prices', [
            'headers' => [
                'Content-type' => 'application/json',
                'Client-Id' => $this->clientId,
                'Api-Key' => $this->token
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        if($request->getStatusCode() === 200) {
            return json_decode($request->getBody()->getContents());
        }

        return false;
    }

    public function getProducts($limit = 600)
    {
        $data = [
            'filter'    => [
                "visibility" => 'ALL',
            ],
            'limit' => $limit
        ];
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'v2/product/list', [
            'headers' => [
                'Content-type' => 'application/json',
                'Client-Id' => $this->clientId,
                'Api-Key' => $this->token
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        if($request->getStatusCode() === 200) {
            return $request->getBody()->getContents();
        }

        return false;
    }
}
