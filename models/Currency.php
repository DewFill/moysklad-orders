<?php

namespace models;

use controllers\CacheController;
use controllers\FetchController;

class Currency
{
    private function __construct(private string $id, private string $name)
    {
    }

    public static function initByUrl($url)
    {
        $cache = new CacheController();
        $cacheObject = $cache->getCache($url, "currency-");
        if ($cacheObject !== null) {
            return $cacheObject;
        }

        $response = FetchController::fetch($url);

        $object = new Currency($response["id"], $response["name"]);
        $cache->setCache($url, $object, 540, "currency-");
        return $object;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}