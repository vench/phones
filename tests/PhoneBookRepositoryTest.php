<?php


namespace Tests;


use App\Models\PhoneBook;
use App\Repositories\PhoneBookRepository;

/**
 * Class PhoneBookRepositoryTest
 * @package Tests
 */
class PhoneBookRepositoryTest extends TestBase
{

    /**
     * @return mixed|PhoneBookRepository
     * @throws \ReflectionException
     */
    private function getRepository() {
        return $this->app()->getObject(PhoneBookRepository::class);
    }

    /**
     * @throws \ReflectionException
     * @depends testCreate
     */
    public function testAll()
    {
        $list = $this->getRepository()->all();
        $this->assertTrue(is_array($list));
        $this->assertTrue(count($list) > 0);
    }

    /**
     * @param PhoneBook $item
     * @depends testCreate
     */
    public function testOne(PhoneBook $item)
    {
        $load = $this->getRepository()->one($item->id);
        $this->assertEquals($item->id, $load->id);
    }

    /**
     * @return PhoneBook
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \ReflectionException
     */
    public function testCreate()
    {
        $faker = \Faker\Factory::create();

        $item = PhoneBook::create([
            'firstName'     => $faker->firstName,
            'phoneNumber'   => "+7911{$faker->biasedNumberBetween(1000000,9999999)}",
        ]);
        $this->getRepository()->create($item);
        $this->assertNotEmpty($item->id);
        return $item;
    }

    /**
     * @param PhoneBook $item
     * @depends testCreate
     */
    public function testUpdate(PhoneBook $item)
    {
        $item->lastName = 'New last name';
        $update = $this->getRepository()->update($item);
        $this->assertTrue($update->lastName == $item->lastName);

        return $item;
    }

    /**
     * @param PhoneBook $item
     * @depends testUpdate
     */
    public function testDelete($item)
    {
        $this->assertTrue($this->getRepository()->delete($item->id));

    }
}