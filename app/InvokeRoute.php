<?php


namespace App;


use Bramus\Router\Router;

class InvokeRoute
{
    /**
     * @var App
     */
    private $app;

    /**
     * @var string
     */
    private $namespace;

    /**
     * InvokeRoute constructor.
     * @param App $app
     * @param string $namespace
     */
    public function __construct(App $app, $namespace = '\App\Controllers') {
        $this->app = $app;
        $this->namespace = $namespace;
    }

    /**
     *
     */
    public function run() {
        $router = new Router();
        $router->setNamespace($this->namespace);
        $router->set404('ErrorController@notFound');
        $router->before('GET|POST|DELETE|PUT', '/phone-book.*', function() {
            // TODO set Middlewares
        });

        $router->get('/phone-book', [$this, 'PhoneBookController@all']);
        $router->get('/phone-book/(\d+)', [$this, 'PhoneBookController@one']);
        $router->post('/phone-book', [$this, 'PhoneBookController@create']);
        $router->put('/phone-book/(\d+)', [$this, 'PhoneBookController@update']);
        $router->delete('/phone-book/(\d+)', [$this, 'PhoneBookController@delete']);
        $router->run();
    }

    /**
     * @param $name
     * @param array $arguments
     * @throws InvokeRouteException
     * @throws \ReflectionException
     */
    public function __call($name, $arguments = []) {
        if(strpos($name, '@') === false) {
            throw new InvokeRouteException("");
        }

        $names =  explode('@', $name);
        if(count($names) != 2) {
            throw new InvokeRouteException("");
        }
        list($className, $method) = $names;

        if(!empty($this->namespace)) {
            $className = "{$this->namespace}\\{$className}";
        }
        $inst = $this->app->getObject($className);

        if(!method_exists($inst, $method)) {
            throw new InvokeRouteException("");
        }
        call_user_func_array([$inst, $method], $arguments);
    }
}