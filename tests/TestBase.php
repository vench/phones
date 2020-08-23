<?php


namespace Tests;

use App\App;
use App\Controllers\Request;
use PHPUnit\Framework\TestCase;

class TestBase extends TestCase
{
    /**
     * @var App
     */
    private $app;

    /**
     * @param $uri
     * @param string $body
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \ReflectionException
     */
    public function httpPost($uri, $body = '')
    {
        return $this->http($uri, 'POST', $body);
    }

    /**
     * @param string $uri
     * @param string $method
     * @param string $body
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \ReflectionException
     */
    public function http($uri, $method = 'GET', $body = '')
    {
        $_SERVER['REQUEST_URI'] = $uri;
        $_SERVER['REQUEST_METHOD'] = $method;

        if (!empty($body)) {
            if (!is_string($body)) {
                $body = json_encode($body);
            }
        }
        $headers = [];

        $request = new Request($method, $uri, $headers, $body);
        $this->app()->setObject(Request::class, $request);
        $response = $this->app()->runTest();
        return $response;
    }

    /**
     * @return App
     */
    public function app()
    {
        if (is_null($this->app)) {
            $this->app = new App();
            $this->app->initConfig();
        }
        return $this->app;
    }

    /**
     * @param $uri
     * @param string $body
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \ReflectionException
     */
    public function httpPut($uri, $body = '')
    {
        return $this->http($uri, 'PUT', $body);
    }

    /**
     * @param $uri
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \ReflectionException
     */
    public function httpGet($uri)
    {
        return $this->http($uri);
    }

    /**
     * @param $uri
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \ReflectionException
     */
    public function httpDelete($uri)
    {
        return $this->http($uri, 'DELETE');
    }

    /**
     *
     */
    protected function setUp()
    {
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';

        $this->app()->initConfig();
    }
}