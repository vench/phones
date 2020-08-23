<?php


namespace Tests;

use App\Models\PhoneBook;

/**
 * Class PhoneBookControllerTest
 * @package Tests
 */
class PhoneBookControllerTest extends TestBase
{

    /**
     *
     */
    public function testAll()
    {
        $response = $this->httpGet('/phone-book');
        $this->assertEquals($response->getStatusCode(), 200);
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('total', $data);
        $this->assertArrayHasKey('offset', $data);
        $this->assertArrayHasKey('limit', $data);
        $this->assertArrayHasKey('items', $data);
    }

    /**
     * @param $item
     * @throws \ReflectionException
     * @depends testCreate
     */
    public function testOne($item)
    {
        $this->assertNotEmpty($item);

        $response = $this->httpGet("/phone-book/{$item['id']}");
        $this->assertEquals($response->getStatusCode(), 200);
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('item', $data);
    }

    /**
     *
     */
    public function testCreate()
    {
        $faker = \Faker\Factory::create();

        $item = PhoneBook::create([
            'firstName'     => $faker->firstName,
            'phoneNumber'   => "+7911{$faker->biasedNumberBetween(1000000,9999999)}",
        ]);
        $body = json_encode($item);
        $response = $this->httpPost('/phone-book', $body);
        $this->assertEquals($response->getStatusCode(), 200);
        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('item', $data);
        $this->assertArrayHasKey('id', $data['item']);
        $this->assertArrayHasKey('firstName', $data['item']);

        return $data['item'];
    }

    /**
     * @param $item
     * @throws \ReflectionException
     * @return  array
     * @depends testCreate
     */
    public function testUpdate($item)
    {
        $this->assertNotEmpty($item);

        $item['firstName'] = 'firstName';
        $body = json_encode($item);
        $response = $this->httpPut("/phone-book/{$item['id']}", $body);

        $this->assertEquals($response->getStatusCode(), 200);
        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('item', $data);
        return $data['item'];
    }

    /**
     * @depends testUpdate
     * @param $item
     */
    public function testDelete($item)
    {
        $this->assertNotEmpty($item);
        $response = $this->httpDelete("/phone-book/{$item['id']}");

        $this->assertEquals($response->getStatusCode(), 200);
    }
}