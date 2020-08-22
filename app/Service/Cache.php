<?php


namespace App\Service;

/**
 * Class Cache
 * @package App\Service
 */
class Cache
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null) {
        return $this->data[$key] ?? $default;
    }

    /**
     * @param $key
     * @param $value
     * @param null $ttl
     */
    public function set($key, $value, $ttl = null) {
        $this->data[$key] = $value;
    }
}