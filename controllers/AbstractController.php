<?php

namespace controllers;
abstract class AbstractController
{
//    abstract function run(string|null $action = null);
    function view(string $name, array $data = [])
    {
        $filepath = __BASE_PATH__ . "/views/" . $name . ".php";
        if (file_exists($filepath)) {
            require($filepath);
        } else {
            die("View \"$name\" not found");
        }

        return true;
    }

    function redirect($location): true
    {
        header("Location: /$location", true);
        return true;
    }

    function output(string $data): void
    {
        echo $data;
    }
}