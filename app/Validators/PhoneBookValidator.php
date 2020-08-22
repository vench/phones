<?php


namespace App\Validators;


use App\Models\PhoneBook;
use App\Repositories\PhoneBookRepository;
use App\Service\Countries;
use App\Service\Timezones;

class PhoneBookValidator
{

    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var PhoneBookRepository
     */
    private $phoneBookRepository;

    /**
     * @var Countries
     */
    private $countries;

    /**
     * @var Timezones
     */
    private $timezones;

    /**
     * PhoneBookValidator constructor.
     * @param PhoneBookRepository $phoneBookRepository
     * @param Countries $countries
     * @param Timezones $timezones
     */
    public function __construct(PhoneBookRepository $phoneBookRepository, Countries $countries, Timezones $timezones)
    {
        $this->phoneBookRepository = $phoneBookRepository;
        $this->countries = $countries;
        $this->timezones = $timezones;
    }

    /**
     * @param PhoneBook $model
     * @return bool
     */
    public function validate(PhoneBook $model)
    {
        $this->errors = [];
        foreach (['firstName', 'phoneNumber'] as $key) {
            if (!$this->validateNotEmptyString($model->{$key})) {
                $this->errors[$key] = 'Field is empty';
            }
        }

        if(!$this->validateTimezoneName($model->timezoneName)) {
            $this->errors['timezoneName'] = 'Timezone Name is invalid';
        }
        if(!$this->validateCountryCode($model->countryCode)) {
            $this->errors['countryCode'] = 'Country Code is invalid';
        }
        if (!$this->validatePhoneNumber($model->phoneNumber, $model->countryCode)) {
            $this->errors['phoneNumber'] = 'Phone number is invalid';
            return false;
        }

        $item = $this->phoneBookRepository->byPhone($model->phoneNumber);
        if(!is_null($item) && $model->id != $item->id)  {
            $this->errors['phoneNumber'] = 'Phone number must be unique';
        }

        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $value
     * @return bool
     */
    public function validateNotEmptyString($value) {
        return !empty(trim($value));
    }

    /**
     * @param string $countryCode
     * @return bool
     */
    public function validateCountryCode($countryCode) {
        if(!empty($countryCode) && empty($this->countries->getCountry($countryCode))) {
            return false;
        }
        return true;
    }

    /**
     * @param string $timezoneName
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function validateTimezoneName($timezoneName) {
        if(!empty($timezoneName) && empty($this->timezones->getTimeZone($timezoneName))) {
            return false;
        }
        return true;
    }

    /**
     * @param $phoneNumber
     * @param null $countryCode
     * @return bool
     */
    public function validatePhoneNumber($phoneNumber, $countryCode = null) {
        try {
            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
            $swissNumberProto = $phoneUtil->parse($phoneNumber, $countryCode);
            return $phoneUtil->isValidNumber($swissNumberProto);
        }  catch ( \Exception $e) { }
        return  false;
    }
}