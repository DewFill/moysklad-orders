<?php

namespace controllers;

use models\User;

class AuthController extends \controllers\AbstractController
{
    function auth($data)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($data["login"]) or empty($data["password"])) {
                var_dump("ERROR");
                return $this->view("auth", ["error" => "Login or password can't be empty"]);
            }
            try {
                $token = User::generateTokenOrThrow($data["login"], $data["password"]);
                setcookie("login", $data["login"], time() + (86400 * 30), "/");
                setcookie("token", $token, time() + 3600, "/");
                $this->redirect("main");
            } catch (\Exception $e) {
                setcookie("token", "");
                return $this->view("auth", ["error" => $e->getMessage()]);
            }
        } else {
            $this->view("auth");
        }
    }

    function viewAuth(): void
    {
        $this->view("auth");
    }

    function logout(): void
    {
        setcookie("token", "", time() - 3600, "/");
        $this->redirect("auth");
    }
}