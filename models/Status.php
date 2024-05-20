<?php

namespace models;

use controllers\CacheController;
use controllers\FetchController;

class Status
{
    public function __construct(private string $id, private string $name, private string $color)
    {
    }

    public static function initByUrl($url): Status
    {
        $cache = new CacheController();
        $cacheObject = $cache->getCache($url, "status-");
        if ($cacheObject !== null) {
            return $cacheObject;
        }

        $response = FetchController::fetch($url);

        $object = new Status($response['id'], $response['name'], $response['color']);
        $cache->setCache($url, $object, 540, "status-");
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

    public function getColor(): string
    {
        return $this->color;
    }
}