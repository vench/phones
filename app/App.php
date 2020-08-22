<?php

namespace App;


use App\Controllers\JsonResponse;
use App\Controllers\Request;
use App\Service\Log;
use Psr\Http\Message\ResponseInterface;
use ReflectionClass;
use ReflectionException;

/**
 * Class App
 * @package App
 */
class App
{

    /**
     * @var array
     */
    private $objectInst = [];


    public function __construct()
    {
    }

    /**
     * @throws ReflectionException
     */
    public function runWeb()
    {
        $this->initConfig();
        $invRoute = $this->initRoute();
        $invRoute->send();
    }

    /**
     * @throws ReflectionException
     */
    private function initConfig()
    {
        $config = $this->getObject(Config::class);
        $config->run();
    }

    /**
     * @param string $className
     * @param bool $newInst
     * @return mixed|object
     * @throws ReflectionException
     */
    public function getObject($className, $newInst = false)
    {
        if (!$newInst && isset($this->objectInst[$className])) {
            return $this->objectInst[$className];
        }

        $ref = new ReflectionClass($className);
        $args = [];
        $refConstruct = $ref->getConstructor();
        $parameters = !is_null($refConstruct) ? $refConstruct->getParameters() : [];
        foreach ($parameters as $parameter) {
            if (!is_null($parameter->getClass())) {
                $argInst = $this->getObject($parameter->getClass()->getName());
                $args[] = $argInst;
            } else if ($parameter->isDefaultValueAvailable()) {
                $argDef = $parameter->getDefaultValue();
                $args[] = $argDef;
            }
        }

        $inst = $ref->newInstanceArgs($args);
        if (!$newInst) {
            $this->objectInst[$className] = $inst;
        }
        return $inst;
    }

    /**
     * @return InvokeRoute
     */
    private function initRoute()
    {
        $this->setObject(Request::class, Request::create());
        $invokeRoute = new InvokeRoute($this);
        try {
            $invokeRoute->run();
        } catch (\HttpException $e) {
            $errorResponse = JsonResponse::createError($e->getMessage(), $e->getCode());
            $invokeRoute->setResponse($errorResponse);
        } catch (\Exception $e) {
            $this->getObject(Log::class)->log($e->getMessage());
            $errorResponse = JsonResponse::createError('Internal application error', 500);
            $invokeRoute->setResponse($errorResponse);
        }

        return $invokeRoute;
    }

    /**
     * @param string $className
     * @param $instance
     */
    public function setObject($className, $instance)
    {
        $this->objectInst[$className] = $instance;
    }

    /**
     * @throws ReflectionException
     */
    public function runCli()
    {
        $this->initConfig();
        printf("App name: %s \n", getenv('APP_NAME'));
    }

    /**
     * @return ResponseInterface
     * @throws ReflectionException
     */
    public function runTest()
    {
        $this->initConfig();
        $invRoute = $this->initRoute();
        return $invRoute->getResponse();
    }

}