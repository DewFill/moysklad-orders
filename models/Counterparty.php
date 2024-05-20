<?php

namespace models;

use controllers\CacheController;
use controllers\FetchController;

class Counterparty
{
    public function __construct(private string $name, private string $url)
    {
    }

    static function initByUrl(string $url): Counterparty
    {
        $cache = new CacheController();
        $cacheObject = $cache->getCache($url, "counterparty-");
        if ($cacheObject !== null) {
            return $cacheObject;
        }

        $response = FetchController::fetch($url);

        $object = new Counterparty($response["name"], $response["meta"]["uuidHref"]);
        $cache->setCache($url, $object, 120, "counterparty-");
        return $object;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}