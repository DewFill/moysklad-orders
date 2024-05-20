<?php

namespace controllers;

use models\OrderCollection;
use models\User;

require __BASE_PATH__ . "/controllers/AbstractController.php";


class MainController extends \controllers\AbstractController
{
    function actionMain($data): void
    {
        $data = OrderCollection::init(User::getToken())->getArrayCopy();
        $this->view("main", $data);
    }
}