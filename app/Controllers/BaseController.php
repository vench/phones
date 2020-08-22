<?php


namespace App\Controllers;

/**
 * Class BaseController
 * @package App\Controllers
 */
abstract class BaseController
{

    /**
     * @var Request
     */
    private $request = null;

    public function __construct()
    {
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        if (is_null($this->request)) {
            $this->request = Request::create();
        }
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $body
     * @param int $code
     * @return JsonResponse
     */
    public function response($body, $code = 200)
    {
        $response = JsonResponse::create($body, $code);
        return $response;
    }

    /**
     * @param $message
     * @param int $code
     * @param null $payload
     * @return JsonResponse
     */
    public function responseError($message, $code = 500, $payload=null)
    {
        $response = JsonResponse::createError($message, $code, $payload);
        return $response;
    }

}