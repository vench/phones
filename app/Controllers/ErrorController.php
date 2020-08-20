<?php


namespace App\Controllers;


class ErrorController extends BaseController
{
    /**
     *
     */
    public function notFound() {
        $this->render([
            'message' => 'page not found',
        ]);
    }

}