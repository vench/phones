<?php


namespace App\Service;

use GuzzleHttp\Client;
use mysql_xdevapi\Exception;

/**
 * Class Timezones
 * @package App\Service
 * @see https://api.hostaway.com/timezones
 */
class Timezones
{
    /**
     * @var Cache
     */
    private $cache;

    /**
     * Timezones constructor.
     * @param Cache $cache
     */
    public function __construct( Cache $cache) {
        $this->cache = $cache;
    }

    /**
     * @param $name
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTimeZone($name) {
        $data = $this->getAll();
        return $data[$name] ?? null;
    }

    /**
     * @return array|mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAll() {
        if(is_null($this->cache)) {
            return $this->load();
        }

        $data = $this->cache->get(__METHOD__);
        if(is_null($data)) {
            $data = $this->load();
            $this->cache->set(__METHOD__, $data, 60);
        }

        return $data;
    }

    /**
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function load() {
        try {
            $client = new Client([
                'timeout'  => 2.0,
            ]);
            $response = $client->get('https://api.hostaway.com/timezones');
            $body = \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
            return $body['result'] ?? [];
        } catch (\Exception $e) {}
        return  [];
    }
}