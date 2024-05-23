<?php
const __BASE_PATH__ = __DIR__;
const CACHE_DIR = __DIR__ . '/.cache';


require "controllers/MainController.php";
require "controllers/AuthController.php";
require "models/User.php";
require "models/OrderCollection.php";
require "models/Order.php";
require "models/Counterparty.php";
require "controllers/CacheController.php";
require "controllers/FetchController.php";
require "controllers/AbstractApiController.php";
require "controllers/OrderController.php";
require "models/Status.php";
require "models/StatusCollection.php";
require "models/Currency.php";

use controllers\AuthController;
use controllers\MainController;

if ($_SERVER['REQUEST_METHOD'] === 'GET' and
    !isset($_COOKIE["token"]) and
    $_SERVER["REQUEST_URI"] !== "/api/auth") {
    (new AuthController())->viewAuth();
} elseif ($_SERVER["REQUEST_URI"] === "/api/auth") {
    (new AuthController())->auth($_POST);
}

if ($_SERVER["REQUEST_URI"] === "/logout") {
    (new AuthController())->logout();
}

if ($_SERVER["REQUEST_URI"] === "/main" or $_SERVER["REQUEST_URI"] === "/") {
    $data = [];
    $data["login"] = $_COOKIE["login"] ?? "";
    (new MainController())->actionMain($data);
}
//if ($_SERVER["REQUEST_URI"] === "/" and $_SERVER['REQUEST_METHOD'] === 'GET') {
//    $controller = new MainController();
//    $controller->actionMain();
//} else
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //handle APIs
    if ($_SERVER["REQUEST_URI"] === "/api/put/order/state") {
        (new controllers\OrderController)->updateStatus($_POST);
    }

}
//
