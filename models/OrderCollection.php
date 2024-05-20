<?php

namespace models;

use ArrayIterator;
use controllers\FetchController;

class OrderCollection extends ArrayIterator
{
    private function __construct(object|array $array = [], int $flags = 0)
    {
        parent::__construct($array, $flags);
    }

    private function add(Order $order): void
    {
        $this->append($order);
    }

    public static function init(string $token): OrderCollection
    {
        $response = FetchController::fetch('https://api.moysklad.ru/api/remap/1.2/entity/customerorder');
//var_dump($response);

        $orderCollection = new OrderCollection();
        foreach (array_reverse($response["rows"]) as $item) {
            $order = new Order(
                id: $item["id"],
                name: $item["name"],
                url: $item["meta"]["uuidHref"],
                created_at: $item["created"],
                counterparty: Counterparty::initByUrl($item["agent"]["meta"]["href"]),
                organisation: Counterparty::initByUrl($item["organization"]["meta"]["href"]),
                sum: $item["sum"],
                currency: Currency::initByUrl($item["rate"]["currency"]["meta"]["href"]),
                status: Status::initByUrl($item["state"]["meta"]["href"]),
                updated_at: $item["updated"]
            );

            $orderCollection->add($order);
        }
        return $orderCollection;
    }
}