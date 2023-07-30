<?php


namespace App\Classes;

use App\Models\MarketPlace;
use App\Models\UserMarketplaceSetting;
use GuzzleHttp\Client;
use Style;
use Illuminate\Support\Str;

class WB
{
    protected $supplierId = '';
    protected $token = '';
    protected $api = '';
    protected $warehouseId;

    public function __construct($user_id)
    {
        if($this->supplierId == '' || $this->token == '' || $this->api == '') {
            $marketplace = MarketPlace::where(['slug' => 'wildberries'])->first();
            if(!$marketplace) {
                abort(500, 'В таблице marketplaces отсутствует запись про Wildberries');
            }

            $marketplace_setting = UserMarketplaceSetting::where(['user_id' => $user_id, 'marketplace_id' => $marketplace->id])->first();
            if(!$marketplace_setting) {
                abort(500, 'У пользователя нет данные о маркетплейсе');
            }

            $this->supplierId   = $marketplace_setting->client_id;
            $this->api          = $marketplace_setting->api;
            $this->token        = $marketplace_setting->client_secret;
            $this->warehouseId  = (int) $marketplace_setting->access_token;
        }
    }

    public function getSupplierId()
    {
        return $this->supplierId;
    }

    public function createProduct($product, $wb_category)
    {
        $properties = $this->getStyleProductProperties($product);

        $product_images = [];
        $images = $product->images;
        if($images) {
            foreach($images as $image) {
                if($image->thumbs == 0) {
                    $product_images[]['value'] = $image->path;
                }
            }
            $product_image = (isset($product_images[0])) ? $product_images[0]['value'] : 'https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg';
        } else {
            $product_image = "https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg";
        }


        $article_pn = str_replace(" ", '-', $product->article_pn);
        $barcode = $this->getGeneratedBarcodeForProduct();
        if(!$barcode) {
            return false;
        }

        $data = [
            "id"=> (string) Str::uuid(),
            "jsonrpc"=> "2.0",
            "params"=> [
                "card"=> [
                    "addin"=> [
                        [
                            "params"=> [
                                [
                                    "value"=> $properties['brand']
                                ]
                            ],
                            "type"=> "Бренд"
                        ],
                        [
                            "params"=> [
                                [
                                    "value"=> $properties['name']
                                ]
                            ],
                            "type"=> "Наименование"
                        ],
                        [
                            "type"=> "Комплектация",
                            "params"=> [
                                [
                                    "value"=> $properties['complex_name']
                                ]
                            ]
                        ],
                        [
                            "type"=> "Описание",
                            "params"=> [
                                [
                                    "value"=> $properties['detail_text'],
                                ]
                            ]
                        ],
                        [
                            "type"=> "Артикул поставщика",
                            "params"=> [
                                [
                                    "value"=> "$product->article",
                                ]
                            ]
                        ],
                    ],
                    "countryProduction"=> $properties['country'],
                    "id"=> (string) Str::uuid(),
                    "nomenclatures"=> [
                        [
                            "addin"=> [
                                [
                                    "type"=> "Фото",
                                    "params"=> [
                                        [
                                            'value' => $product_image
                                        ]
                                    ]
                                ]
                            ],
                            "concatVendorCode"=> $article_pn,
                            "id"=> (string) Str::uuid(),
                            "isArchive"=> false,
                            "variations"=> [
                                [
                                    "addin"=> [
                                        [
                                            "type"=> "Розничная цена",
                                            "params"=> [
                                                [
                                                    "count"=> $product->convertPrice(),
                                                    "units" => "рубли",
                                                    "value" => "рубли"
                                                ]
                                            ]
                                        ]
                                    ],
                                    "barcode"=> $barcode,
                                    "barcodes"=> [
                                        $barcode
                                    ],
                                    "chrtId"=> 0,
                                    "errors"=> [
                                        "string"
                                    ],
                                    "id"=> (string) Str::uuid()
                                ]
                            ],
                            "vendorCode"=> (string) $product->article
                        ]
                    ],
                    "object"=> $wb_category->name,
                    "supplierId"=> $this->supplierId,
                    "supplierVendorCode"=> (string) $product->article,
                ],
                "supplierID"=> $this->supplierId
            ]
        ];

        if(!is_null($properties['warranty'])) {
            $data['params']['card']['addin'][] = [
                "type"=> "Гарантийный срок",
                "params"=> [
                    [
                        "value"=> $properties['warranty'],
                    ]
                ]
            ];
        }

        if(!is_null($properties['general_color'])) {
            $data['params']['card']['addin'][] = [
                "type"=> "Основной цвет",
                "params"=> [
                    [
                        "value"=> $properties['general_color'],
                    ]
                ]
            ];
        }

        if(count($product_images) > 1) {
            foreach($product_images as $key=>$arr) {
                if($key == 0) {
                    continue;
                }

                $data['params']['card']['nomenclatures'][0]['addin'][] = [
                    "type"=> "Фото",
                    "params"=> [
                        [
                            "value"=> $arr['value'],
                        ]
                    ]
                ];
            }
        }


        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'card/create', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        return $request->getBody()->getContents();
    }

    public function uploadProduct($product, $wb_category)
    {
        $properties = $this->getStyleProductProperties($product);

        if(!$properties) {
            return false;
        }

        $barcode = $this->getGeneratedBarcodeForProduct();
        if(!$barcode) {
            return false;
        }

        $article = "17".$product->article."".$product->article;
        $product->wb_imtId = $article;
        $product->wb_barcode = $barcode;
        $product->save();

        $data = [[
            'vendorCode' => (string) $article,
            'characteristics' => [
                [
                    'Наименование' => (string) Str::limit($properties['name'], 40, '')
                ],
                [
                    'Бренд' => (string) $properties['brand']
                ],
                [
                    'Комплектация' => (string) $properties['complex_name']
                ],
                [
                    'Описание' => (string) $properties['detail_text']
                ],
                [
                    'Гарантийный срок' => (string) $properties['warranty']
                ],
                [
                    'Предмет' => (string) $wb_category->name
                ],
                [
                    'Страна производства' => (string) $properties['country']
                ],
                [
                    'Ширина упаковки' => 15
                ],
                [
                    'Длина упаковки' => 15
                ],
                [
                    'Высота упаковки' => 10
                ],
            ],
            'sizes' => [
                [
                    'techSize' => '',
                    'wbSize' => '',
                    'price' => (int) $product->convertPrice(),
                    'skus' => [
                        (string) $barcode
                    ]
                ]
            ]
        ]];

        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $data = "[".$data."]";

        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'content/v1/cards/upload', [
            'headers' => [
                'Authorization' => $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => $data
        ]);

        $result = json_decode($request->getBody()->getContents());

        if($result->error) {
            return false;
        }

        return $result;
    }

    /**
     * TODO: Надо переписать АПИ
     */
    public function getCategories()
    {
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('GET', '/api/v1/config/get/object/parent/list?top=1000', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ]
        ]);
        return $request->getBody()->getContents();
    }

    // TODO:: Надо переписать
    public function getCategoryChild($parent_name)
    {
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('GET', '/api/v1/config/object/byparent?parent=' . $parent_name, [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ]
        ]);
        return $request->getBody()->getContents();
    }

    public function getProductStocks()
    {
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('GET', '/api/v2/stocks?skip=0&take=1000', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ]
        ]);
        return json_decode($request->getBody()->getContents());
    }

    public function getWarehouses()
    {
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('GET', '/api/v2/warehouses', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ]
        ]);
        return $request->getBody()->getContents();
    }

    public function updateStocks($product)
    {
        $client = new Client(['base_uri' => $this->api]);

        $data = [
            'stocks' => [
                [
                    'sku' => (string) $product->wb_barcode,
                    'amount' => (int) $product->getQuantity()
                ]
            ]
        ];


        //$data = "[".json_encode($data)."]";

        $request = $client->request('PUT', 'api/v3/stocks/' . $this->warehouseNewId, [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data)
        ]);

        return $request->getBody()->getContents();
    }

    public function cancelStocks($product)
    {
        $client = new Client(['base_uri' => $this->api]);
        $data = [
            "barcode" => (string) $product->wb_barcode,
            "stock" => 0,
            "warehouseId" => (int) $this->warehouseId
        ];


        $data = "[".json_encode($data)."]";

        $request = $client->request('POST', 'api/v2/stocks', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => $data
        ]);

        return $request->getBody()->getContents();
    }

    public function getGeneratedBarcodeForProduct()
    {
        $client = new Client(['base_uri' => $this->api]);

        $data = [
            'count' => 1
        ];

        $request = $client->request('POST', 'content/v1/barcodes', [
            'headers' => [
                'Authorization' => $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        $barcode = json_decode($request->getBody()->getContents());
        if($barcode->error == false) {
            return $barcode->data[0];
        }

        return false;
    }

    public function getProductCardList($limit = 1000, $offset = 0)
    {
        $client = new Client(['base_uri' => $this->api]);

        $data = [
            'sort' => [
                'cursor' => [
                    'limit' => $limit,
                ],
            ]
        ];

        $request = $client->request('POST', 'content/v1/cards/cursor/list', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        return json_decode($request->getBody()->getContents());
    }

    public function updatePrices($price, $nmId)
    {
        try {
            $client = new Client(['base_uri' => $this->api]);
            $data = [
                "nmId" => (int) $nmId,
                "price" => (int) $price
            ];

            $data = "[" . json_encode($data) . "]";

            $request = $client->request('POST', 'public/api/v1/prices', [
                'headers' => [
                    'Authorization' => "Bearer " . $this->token,
                    'Content-type' => 'application/json'
                ],
                'body' => $data
            ]);

            if($request->getStatusCode() == 200) {
                return $request->getBody()->getContents();
            }
        } catch (\Exception $exception) {
            return false;
        }

    }

    // Метод устарел
    public function getProductByImtId($product)
    {
        $client = new Client(['base_uri' => $this->api]);
        $data = [
            "id" => (string) Str::uuid(),
            "jsonrpc" => "2.0",
            "params" => [
                "imtID" => (int) $product->wb_imtId,
                "supplierID" => $this->supplierId
            ]
        ];

        $request = $client->request('POST', '/card/cardByImtID', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        return json_decode($request->getBody()->getContents());
    }

    public function getProductByArticle($article_code)
    {
        $client = new Client(['base_uri' => $this->api]);

        $data = [
            'vendorCodes' => [
                (string) $article_code
            ]
        ];

        $request = $client->request('POST', 'content/v1/cards/filter', [
            'headers' => [
                'Authorization' => $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        return json_decode($request->getBody()->getContents());
    }

    public function getStyleProductProperties($product)
    {
        $properties = [];
        $product_feature = Style::getProductFeature($product->article);
        if(isset($product_feature->status) && $product_feature->status == 'error') {
            return false;
        }

        if(isset($product_feature[0])) {
            $product_feature = $product_feature[0];
            $arr = (array) $product_feature->properties;
            $properties['name'] = $this->removeSymbols($product->name);
            $properties['complex_name'] = $this->removeSymbols($product->name) . " - 1" . $arr['Базовая единица'];
            $properties['brand'] = (isset($product_feature->brand)) ? $product_feature->brand : 'No name';
            $properties['warranty'] = (isset($product_feature->warranty)) ? $product_feature->warranty : null;
            $properties['detail_text'] = Str::limit($product_feature->detailtext, 999);
            $properties['detail_text'] = $this->removeSymbols($properties['detail_text']);
            $properties['country'] = (isset($arr['Страна производства'])) ? $arr['Страна производства'] : "Китай";
            $properties['country'] = ($properties['country'] == 'Сделано в Китае') ? "Китай" : $properties['country'];
            $properties['main_camera'] = (isset($arr['Основная камера'])) ? $arr['Основная камера'] : null;
            $properties['ram'] = (isset($arr['Оперативная память'])) ? $arr['Оперативная память'] : null;
            $properties['cpu'] = (isset($arr['Процессор'])) ? $arr['Процессор'] : null;
            $properties['cpu_frequency'] = (isset($arr['Частота процессора'])) ? $arr['Частота процессора'] : null;
            $properties['battery'] = (isset($arr['Аккумулятор'])) ? $arr['Аккумулятор'] : null;
            $properties['number_cores'] = (isset($arr['Количество ядер'])) ? $arr['Количество ядер'] : null;
            $properties['built_memory'] = (isset($arr['Встроенная память'])) ? $arr['Встроенная память'] : null;
            $properties['screen_diagonal'] = (isset($arr['Диагональ экрана'])) ? $arr['Диагональ экрана'] : null;
            $properties['screen_resolution'] = (isset($arr['Разрешение экрана'])) ? $arr['Разрешение экрана'] : null;
            $properties['wifi'] = (isset($arr['Wi-Fi'])) ? $arr['Wi-Fi'] : null;
            $properties['front_camera'] = (isset($arr['Фронтальная камера'])) ? $arr['Фронтальная камера'] : null;
            $properties['bluetooth'] = (isset($arr['Bluetooth'])) ? $arr['Bluetooth'] : null;
            $properties['sim_card'] = (isset($arr['Количество SIM-карт'])) ? $arr['Количество SIM-карт'] : null;
            $properties['weight'] = (isset($arr['Вес'])) ? $arr['Вес'] : null;
            $properties['wireless_charger'] = (isset($arr['Беспроводная зарядка'])) ? $arr['Беспроводная зарядка'] : null;
            $properties['general_color'] = (isset($arr['Цвет'])) ? $arr['Цвет'] : null;
            $properties['general_color'] = ($properties['general_color'] == 'Чёрный') ? 'Черный' : $properties['general_color'];
            $properties['general_color'] = ($properties['general_color'] == 'Чрный') ? 'Черный' : $properties['general_color'];
            $properties['general_color'] = mb_strtolower($properties['general_color']);
        } else {
            $properties['name'] = $this->removeSymbols($product->name);
            $properties['complex_name'] = $this->removeSymbols($product->name) . " - 1шт";
            $properties['brand'] = "No name";
            $properties['warranty'] = null;
            $properties['detail_text'] = "";
            $properties['country'] = 'Китай';
            $properties['main_camera'] = null;
            $properties['ram'] = null;
            $properties['cpu'] = null;
            $properties['cpu_frequency'] = null;
            $properties['battery'] = null;
            $properties['built_memory'] = null;
            $properties['screen_diagonal'] = null;
            $properties['screen_resolution'] = null;
            $properties['wifi'] = null;
            $properties['front_camera'] = null;
            $properties['bluetooth'] = null;
            $properties['sim_card'] = null;
            $properties['weight'] = null;
            $properties['wireless_charger'] = null;
            $properties['general_color'] = null;
        }

        return $properties;
    }

    public function removeSymbols($string) :string
    {
        $symbols = [
            '/', '*', '#', '@', '$', '®'
        ];
        foreach($symbols as $symbol) {
            $string = str_replace($symbol, ' ', $string);
        }
        return $string;
    }

    public function updateProductImages($article, $arrImages)
    {
        $dataImg = [
            'vendorCode' => (string) $article,
            'data' => $arrImages
        ];
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'content/v1/media/save', [
            'headers' => [
                'Authorization' => $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($dataImg)
        ]);

        $resultImg = json_decode($request->getBody()->getContents());

        if($resultImg->error) {
            return false;
        }

        return true;
    }

    public function updateProduct($product, $wb_category, $productDetails)
    {
        $properties = $this->getStyleProductProperties($product);

        if(!$properties) {
            return false;
        }

        if(!$productDetails->data[0]) {
            return false;
        }

        $data = [[
            'imtID' => (int) $productDetails->data[0]->imtID,
            'nmID' => (int) $productDetails->data[0]->nmID,
            'vendorCode' => (string) $product->wb_imtId,
            'characteristics' => [
                [
                    'Наименование' => (string) Str::limit($properties['name'], 40, '')
                ],
                [
                    'Бренд' => (string) $properties['brand']
                ],
                [
                    'Комплектация' => (string) $properties['complex_name']
                ],
                [
                    'Описание' => (string) $properties['detail_text']
                ],
                [
                    'Гарантийный срок' => (string) $properties['warranty']
                ],
                [
                    'Предмет' => (string) $wb_category->name
                ],
                [
                    'Страна производства' => (string) $properties['country']
                ],
                [
                    'Ширина упаковки' => 15
                ],
                [
                    'Глубина упаковки' => 15
                ],
                [
                    'Высота упаковки' => 10
                ],
            ],
            'sizes' => [
                [
                    'techSize' => '',
                    'wbSize' => '',
                    'chrtID' => (int) $productDetails->data[0]->sizes[0]->chrtID,
                    'price' => (int) $product->convertPrice(),
                    'skus' => [
                        (string) $product->wb_barcode
                    ]
                ]
            ]
        ]];

        $data = json_encode($data, JSON_UNESCAPED_UNICODE);

        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'content/v1/cards/update', [
            'headers' => [
                'Authorization' => $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => $data
        ]);

        $result = json_decode($request->getBody()->getContents());

        if($result->error) {
            return false;
        }

        return $result;
    }

    public function deleteStocks($barcode)
    {
        $client = new Client(['base_uri' => $this->api]);
        $data = [
            "skus" => [$barcode]
        ];


        //$data = "[".json_encode($data)."]";

        $request = $client->request('DELETE', 'api/v3/stocks/' . $this->warehouseId, [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data)
        ]);

        return $request->getBody()->getContents();
    }
}
