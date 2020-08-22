<?php


namespace App\Controllers;


use App\Models\PhoneBook;
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

    /**
     * PhoneBookController constructor.
     * @param PhoneBookRepository $phoneBookRepository
     * @param PhoneBookValidator $phoneBookValidator
     */
    public function __construct(PhoneBookRepository $phoneBookRepository, PhoneBookValidator $phoneBookValidator)
    {
        parent::__construct();

        $this->phoneBookRepository = $phoneBookRepository;
        $this->phoneBookValidator = $phoneBookValidator;
    }

    /**
     *
     */
    public function all()
    {

        $request = $this->getRequest();
        $limit = $request->getInt('limit', 10);
        $offset = $request->getInt('offset', 0);

        $items = $this->phoneBookRepository->all($offset, $limit);
        $total = $this->phoneBookRepository->total();
        return $this->response([
            'items' => $items,
            'limit' => $limit,
            'total' => $total,
            'offset' => $offset,
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function one($id)
    {
        $item = $this->phoneBookRepository->one($id);
        if (is_null($item)) {
            return $this->responseError('not found', 404);
        }
        return $this->response([
            'item' => $item,
        ]);
    }

    /**
     * @return JsonResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create()
    {

        $request = $this->getRequest();
        $data = $request->json() ?? [];
        $model = PhoneBook::create($data);
        if (!$this->phoneBookValidator->validate($model)) {
            return  $this->responseError('validation error', 422, $this->phoneBookValidator->getErrors());
        }
        $this->phoneBookRepository->create($model);

        return $this->response([
            'item' => $model,
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function update($id)
    {
        $request = $this->getRequest();
        $data = $request->json();
        $model = PhoneBook::create($data);
        $model->id = $id;

        if (!$this->phoneBookValidator->validate($model)) {
            return  $this->responseError('validation error', 422, $this->phoneBookValidator->getErrors());
        }

        $update = $this->phoneBookRepository->update($model);
        if (is_null($update)) {
            return $this->responseError('not found', 404);
        }

        return $this->response([
            'item' => $update,
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        if (!$this->phoneBookRepository->delete($id)) {
            return $this->responseError('not found', 404);
        }
        return $this->response([]);
    }


}