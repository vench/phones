<?php


namespace App\Validators;


use App\Models\PhoneBook;

class PhoneBookValidator
{

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @param PhoneBook $model
     * @return bool
     */
    public function validate(PhoneBook $model) {
        $this->errors = [];
        if(empty($model->firstName)) {
            $this->errors['firstName'] = 'not ';
        }
        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }
}