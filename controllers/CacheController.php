<?php

namespace controllers;

class CacheController
{
    function getCacheFilePath(string $key, string $prefix): string
    {
        return CACHE_DIR . "/$prefix" . md5($key) . '.cache';
    }

    function setCache(string $key, $value, int $ttl = 120, string $prefix = ""): void
    {
        if (!is_dir(CACHE_DIR)) {
            mkdir(CACHE_DIR, recursive: true);
        }

        $data = [
            'value' => $value,
            'expires' => time() + $ttl
        ];
        $filePath = $this->getCacheFilePath($key, $prefix);
        file_put_contents($filePath, serialize($data));
    }

    function getCache(string $key, string $prefix = "")
    {
        $filePath = $this->getCacheFilePath($key, $prefix);
        if (!file_exists($filePath)) {
            return null;
        }

        $data = unserialize(file_get_contents($filePath));

        if ($data['expires'] < time()) {
            unlink($filePath);
            return null;
        }

        return $data['value'];
    }

    function deleteCache(string $key, string $prefix = ""): void
    {
        $filePath = $this->getCacheFilePath($key, $prefix);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}