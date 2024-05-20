<?php

namespace models;

use controllers\CacheController;
use controllers\FetchController;

class StatusCollection extends \ArrayIterator
{
    private function __construct(object|array $array = [], int $flags = 0)
    {
        parent::__construct($array, $flags);
    }

    public static function init(): StatusCollection
    {
        $url = "https://api.moysklad.ru/api/remap/1.2/entity/customerorder/metadata/";

        $cache = new CacheController();
        $cacheObject = $cache->getCache($url, "status_collection-");
        if ($cacheObject !== null) {
            return $cacheObject;
        }

        $res = FetchController::fetch($url);
        $statusCollection = new StatusCollection();

        foreach ($res["states"] as $status) {
            $statusCollection->append(
                new Status(
                    $status["id"],
                    $status["name"],
                    $status["color"]));
        }

        $cache->setCache($url, $statusCollection, 540, "status_collection-");

        return $statusCollection;
    }
}