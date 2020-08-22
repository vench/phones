<?php


namespace App\Cache;


interface Cacher
{

    public function get($key);

    public function set($key, $value, $ttl = null);
}