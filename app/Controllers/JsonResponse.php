<?php


namespace App\Controllers;


use GuzzleHttp\Psr7\Response;

/**
 * Class JsonResponse
 * @package App\Controllers
 */
class JsonResponse extends Response
{

    /**
     * @param $message
     * @param int $code
     * @param null $payload
     * @return static
     */
    public static function createError($message, $code = 500, $payload = null)
    {
        return static::create([
            'error' => [
                'code' => $code,
                'message' => $message,
                'payload' => $payload,
            ],
        ], $code);
    }

    /**
     * @param $body
     * @param int $code
     * @return static
     */
    public static function create($body, $code = 200)
    {
        if (!is_string($body)) {
            $body = json_encode($body);
        }
        $response = new static($code, [], $body);
        $response = $response->withHeader('Content-Type', 'application/json');
        return $response;
    }
}