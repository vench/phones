<?php

namespace App;



/**
 * Class App
 * @package App
 */
class App
{

    private $objectInst = [];


    public function __construct() {

    }

    /**
     *
     */
    public function run() {
        $this->initConfig();
        $this->initRoute();
    }

    /**
     * @throws \ReflectionException
     */
    private function initConfig() {
        $config = $this->getObject(Config::class);
        $config->run();
    }

    /**
     *
     */
    private function initRoute() {
        $invokeRoute = new InvokeRoute($this);
        $invokeRoute->run();
    }

    /**
     * @param string $className
     * @param bool $newInst
     * @return mixed|object
     * @throws \ReflectionException
     */
    public function getObject($className, $newInst = false) {

        if(!$newInst && isset($this->objectInst[$className])) {
            return $this->objectInst[$className];
        }

        $ref = new \ReflectionClass($className);
        $args = [];
        $refConstruct = $ref->getConstructor();
        $parameters = !is_null($refConstruct) ? $refConstruct->getParameters()  : [];
        foreach ($parameters as $parameter) {
            if(!is_null($parameter->getClass())) {
                $argInst = $this->getObject($parameter->getClass()->getName());
                $args[] = $argInst;
            } else if($parameter->isDefaultValueAvailable()) {
                $argDef = $parameter->getDefaultValue();
                $args[] = $argDef;
            }
        }

        $inst =$ref->newInstanceArgs($args);
        if($newInst) {
            $this->objectInst[$className]   =$inst;
        }
        return $inst;
    }
}