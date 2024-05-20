<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/public/uikit/css/uikit.css">
    <link rel="stylesheet" href="/public/auth.css">
</head>
<body>
<main>
    <form method="post" action="/api/auth">
        <div class="input">
            <label for="login">Логин:</label>
            <input id="login" class="ui-input" type="text" name="login" autocomplete="username">
        </div>

        <div class="input">
            <label for="password">Пароль:</label>
            <input id="password" class="ui-input" type="password" name="password" autocomplete="current-password">
        </div>

        <p class="error"><?= $data["error"] ?? "" ?></p>

        <div class="buttons">
            <button class="button button--success">Сохранить</button>
        </div>
    </form>
</main>
</body>
</html>