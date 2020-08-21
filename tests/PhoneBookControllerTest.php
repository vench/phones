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
    public function testAll() {
        $response = $this->httpGet('/phone-book');
        $this->assertEquals($response->getStatusCode(), 200);
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('total', $data);
        $this->assertArrayHasKey('offset', $data);
        $this->assertArrayHasKey('limit', $data);
        $this->assertArrayHasKey('items', $data);
    }

    /**
     *
     */
    public function testOne() {
        $id = $this->testCreate();
        $this->assertNotEmpty($id);

        $response = $this->httpGet("/phone-book/{$id}");
        $this->assertEquals($response->getStatusCode(), 200);
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('item', $data);
    }

    /**
     *
     */
    public function testCreate() {
        $item = PhoneBook::create([
            'firstName' => 'firstName',
        ]);
        $body = json_encode($item);
        $response = $this->httpPost('/phone-book', $body);

        $this->assertEquals($response->getStatusCode(), 200);
        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('item', $data);
        $this->assertArrayHasKey('id', $data['item']);
        $this->assertArrayHasKey('firstName', $data['item']);

        return $data['item']['id'];
    }

    /**
     *
     */
    public function testUpdate() {
        $id = $this->testCreate();
        $this->assertNotEmpty($id);

        $item = PhoneBook::create([
            'firstName' => 'firstName',
        ]);
        $body = json_encode($item);
        $response = $this->httpPut("/phone-book/{$id}", $body);

        $this->assertEquals($response->getStatusCode(), 200);
        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('item', $data);
    }

    /**
     *
     */
    public function testDelete() {
        $id = $this->testCreate();
        $this->assertNotEmpty($id);
        $response = $this->httpDelete("/phone-book/{$id}");

        $this->assertEquals($response->getStatusCode(), 200);
    }
}