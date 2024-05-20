<?php

namespace models;

use controllers\FetchController;

class Order
{
    public function __construct(private string       $id,
                                private string       $name,
                                private string       $url,
                                private string       $created_at,
                                private Counterparty $counterparty,
                                private Counterparty $organisation,
                                private string       $sum,
                                private Currency     $currency,
                                private Status       $status,
                                private string       $updated_at,
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }


    public function getCounterparty(): Counterparty
    {
        return $this->counterparty;
    }

    public function getOrganisation(): Counterparty
    {
        return $this->organisation;
    }

    public function getSum(): string
    {
        return $this->sum;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    static function initByUrl($url)
    {
        $item = FetchController::fetch($url);
        return new Order(id: $item["id"],
            name: $item["name"],
            url: $item["meta"]["uuidHref"],
            created_at: $item["created"],
            counterparty: Counterparty::initByUrl($item["agent"]["meta"]["href"]),
            organisation: Counterparty::initByUrl($item["organization"]["meta"]["href"]),
            sum: $item["sum"],
            currency: Currency::initByUrl($item["rate"]["currency"]["meta"]["href"]),
            status: Status::initByUrl($item["state"]["meta"]["href"]),
            updated_at: $item["updated"]);
    }
}