<?php


namespace App\Controllers;

/**
 * Class ErrorController
 * @package App\Controllers
 */
class ErrorController extends BaseController
{
    /**
     *
     */
    public function notFound() {
        return $this->response([
            'message' => 'page not found',
        ], 404);
    }

}