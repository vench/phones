<?php


namespace App\Controllers;

use GuzzleHttp\Psr7\Request as GuzzleRequest;

/**
 * Class Request
 * @package App\Controllers
 */
class Request extends GuzzleRequest
{

    /**
     * Request constructor.
     * @param $method
     * @param $uri
     * @param array $headers
     * @param null $body
     * @param string $version
     */
    public function __construct($method, $uri, array $headers = [], $body = null, $version = '1.1')
    {
        parent::__construct($method, $uri, $headers, $body, $version);
    }

    /**
     * @return Request
     */
    public static function create()
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $headers = getallheaders();
        $body = file_get_contents('php://input');

        return new static(
            $method,
            $uri,
            $headers,
            $body
        );
    }

    /**
     * @param $key
     * @param null $default
     * @return int
     */
    public function getInt($key, $default = null)
    {
        return intval($this->get($key, $default));
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        $value = filter_input(INPUT_GET, $key);
        return $value ?? $default;
    }

    /**
     * @return mixed
     */
    public function json()
    {
        $contents = $this->getBody()->getContents();
        $json = json_decode($contents, true);
        return $json;
    }

}