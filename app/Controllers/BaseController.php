<?php


namespace App\Controllers;



interface Renderer {
    public function render($data, $code = 200);
}

class JsonRenderer implements Renderer {
    public function render($data, $code = 200) {
        echo json_encode($data);
    }
}

abstract class BaseController
{
    private $renderer;

    public function __construct() {
        $this->renderer = new JsonRenderer();
    }

    public function render($data) {
        $this->renderer->render($data);
    }

}