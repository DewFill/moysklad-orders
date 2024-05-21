<?php

use models\StatusCollection; ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/public/uikit/css/uikit.min.css">
    <link rel="stylesheet" href="/public/main.css">
    <script defer src="/public/script.js"></script>
</head>
<body>
<div>
    <div class="buttons account">
        <p><?= $data["login"] ?? "" ?></p>
        <a href="/logout">
            <button class="button">Выйти</button>
        </a>
    </div>
</div>
<table class="ui-table">
    <thead>
    <tr>
        <th>№</th>
        <th>Время</th>
        <th>Контрагент</th>
        <th>Организация</th>
        <th>Сумма</th>
        <th>Валюта</th>
        <th>Статус</th>
        <th>Когда изменен</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $statusCollection = StatusCollection::init();
    foreach ($data["orders"] as $order): ?>
        <tr>
            <td><a href="<?= $order->getUrl() ?>"><?= $order->getName() ?></a></td>
            <td><?= $order->getCreatedAt() ?></td>
            <td><a href="<?= $order->getCounterparty()->getUrl() ?>"><?= $order->getCounterparty()->getName() ?></a>
            </td>
            <td><?= $order->getOrganisation()->getName() ?></td>
            <td><?= $order->getSum() ?></td>
            <td><?= $order->getCurrency()->getName() ?></td>
            <td id="status-<?= $order->getId() ?>">
                <div class="current-status clr-<?= $order->getStatus()->getColor() ?>"
                     data-color="<?= $order->getStatus()->getColor() ?>"
                     data-orderid="<?= $order->getId() ?>"
                >
                    <div class="arrow1 arrow2"></div>
                    <div class="current-status-text"><?= $order->getStatus()->getName() ?></div>
                </div>
                <div class="statuses" style="display: none; z-index: 2">
                    <?php foreach ($statusCollection as $status): ?>
                        <div class="status"
                             data-statusid="<?= $status->getId() ?>"
                             data-color="<?= $status->getColor() ?>" data-uuid="<?= $status->getId() ?>">
                            <div class="square clr-<?= $status->getColor() ?>"></div>
                            <div class="text"><?= $status->getName() ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </td>
            <td><?= $order->getUpdatedAt() ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>