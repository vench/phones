<?php


namespace App\Repositories;


use App\Config;
use App\Models\PhoneBook;

/**
 * Class PhoneBookRepository
 * @package App\Repositories
 */
class PhoneBookRepository
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * PhoneBookRepository constructor.
     * @param Config $config
     * @throws \Doctrine\ORM\ORMException
     */
    public function __construct(Config $config)
    {

        $this->entityManager = $config->createEntityManager();
    }

    /**
     * @param $phone
     * @return mixed|object|null
     */
    public function byPhone($phone) {
        $repo = $this->entityManager->getRepository(PhoneBook::class);
        $items = $repo->findBy([
            'phoneNumber'  => $phone,
        ]);
        if(count($items) > 0) {
            return $items[0];
        }
        return null;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function all($offset = 0, $limit = 10)
    {
        $repo = $this->entityManager->getRepository(PhoneBook::class);
        $list = $repo->findBy([], [], $limit, $offset);
        return $list;
    }

    /**
     * @return int
     */
    public function total()
    {
        $repo = $this->entityManager->getRepository(PhoneBook::class);
        return $repo->count([]);
    }

    /**
     * @param PhoneBook $phoneBook
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(PhoneBook $phoneBook)
    {
        $phoneBook->insertedOn = new \DateTime("now");
        $phoneBook->updatedOn = new \DateTime("now");
        $this->entityManager->persist($phoneBook);
        $this->entityManager->flush();
    }

    /**
     * @param PhoneBook $phoneBook
     * @return PhoneBook|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(PhoneBook $phoneBook)
    {
        $phoneBookOld = $this->one($phoneBook->id);
        if (is_null($phoneBookOld)) {
            return null;
        }

        $phoneBookOld->countryCode = $phoneBook->countryCode;
        $phoneBookOld->firstName = $phoneBook->firstName;
        $phoneBookOld->lastName = $phoneBook->lastName;
        $phoneBookOld->phoneNumber = $phoneBook->phoneNumber;
        $phoneBookOld->timezoneName = $phoneBook->timezoneName;
        $phoneBookOld->updatedOn = new \DateTime("now");

        $this->entityManager->persist($phoneBookOld);
        $this->entityManager->flush();
        return $phoneBookOld;
    }

    /**
     * @param $id
     * @return PhoneBook
     */
    public function one($id)
    {
        $repo = $this->entityManager->getRepository(PhoneBook::class);
        $item = $repo->find($id);
        return $item;
    }

    /**
     * @param $id
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete($id)
    {
        $phoneBook = $this->one($id);
        if (is_null($phoneBook)) {
            return false;
        }
        $this->entityManager->remove($phoneBook);
        $this->entityManager->flush();
        return true;
    }
}