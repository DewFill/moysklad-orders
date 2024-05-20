<?php

namespace controllers;

class AbstractApiController extends AbstractController
{
    function viewSuccess($data = null)
    {
        header('Content-type: application/json');
        $this->output(json_encode([
            "action" => "success",
            "data" => $data
        ]));

        return true;
    }

    function viewError($data = null)
    {
        header('Content-type: application/json');
        $this->output(json_encode([
            "action" => "error",
            "data" => $data
        ]));

        return true;
    }
}