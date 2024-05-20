<?php

namespace controllers;

use models\Order;
use models\User;

class OrderController extends AbstractApiController
{
    function updateStatus($data)
    {
        if (!isset($_POST["order_id"]) or !isset($_POST["status_id"]) or !isset($_POST["token"])) {
            return self::viewError("Data missing");
        }
        $order_id = $_POST["order_id"];
        $status_id = $_POST["status_id"];
        $token = $_POST["token"];

        $ch = curl_init();

        $order_url = "https://api.moysklad.ru/api/remap/1.2/entity/customerorder/$order_id";
        curl_setopt($ch, CURLOPT_URL, $order_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');

        $change = [
            "state" => [
                "meta" => [
                    "href" => "https://api.moysklad.ru/api/remap/1.2/entity/customerorder/metadata/states/$status_id",
                    "type" => "state",
                    "mediaType" => "application/json",
                ]],
        ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($change));

        $headers = array();
        $headers[] = 'Authorization: Bearer ' . $token;
        $headers[] = 'Accept-Encoding: gzip';
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        $result = json_decode($result, true);
        curl_close($ch);

        $order = Order::initByUrl($order_url);

        return self::viewSuccess(["updated_at" => $order->getUpdatedAt()]);
    }
}