<?php


namespace App\Controllers;


use App\Repositories\PhoneBookRepository;
use App\Validators\PhoneBookValidator;

/**
 * Class PhoneBookController
 * @package App\Controllers
 */
class PhoneBookController extends BaseController
{

    /**
     * @var PhoneBookRepository
     */
    private $phoneBookRepository;

    /**
     * @var PhoneBookValidator
     */
    private $phoneBookValidator;

    public function __construct(PhoneBookRepository $phoneBookRepository, PhoneBookValidator $phoneBookValidator)
    {
        parent::__construct();

        $this->phoneBookRepository = $phoneBookRepository;
        $this->phoneBookValidator = $phoneBookValidator;
    }

    public function all() {
        $this->render([]);
    }

    public function one($id) {
        $this->render([
            'id' => $id,
        ]);
    }

    public function create() {

    }

    public function update($id) {

    }


}