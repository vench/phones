<?php


namespace App\Repositories;


use App\Models\PhoneBook;

class PhoneBookRepository
{

    /**
     * @param int $offset
     * @param int $limit
     * @return PhoneBook[]
     */
    public function all($offset = 0, $limit = 10) {

        return [];
    }

    /**
     * @return int
     */
    public function total() {
        return 0;
    }

    /**
     * @param $id
     * @return PhoneBook
     */
    public function one($id) {
        return  PhoneBook::create([
            'id'    => $id,
        ]);
    }

    /**
     * @param PhoneBook $phoneBook
     */
    public function create(PhoneBook $phoneBook) {
        $phoneBook->id = 1;
    }

    /**
     * @param PhoneBook $phoneBook
     * @return int
     */
    public function update(PhoneBook $phoneBook) {
        return 1;
    }
}