<?php


namespace Tests;

use PHPUnit\Framework\TestCase;
use \App\App;

class TestBase extends TestCase
{
    /**
     * @var App
     */
    private $app;



    /**
     * @return App
     */
    public function app() {
        if(is_null($this->app)) {
            $this->app = new App();
        }
        return $this->app;
    }
}