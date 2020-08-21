<?php


namespace App\Models;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PhoneBook
 * @package App\Models
 * @ORM\Entity
 * @ORM\Table(name="phone_book")
 */
class PhoneBook
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;

    /**
     * @var string
     * @ORM\Column(type="string", name="first_name", nullable=false)
     */
    public $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", name="last_name")
     */
    public $lastName;

    /**
     * @var string
     * @ORM\Column(type="string", name="phone_number", unique=True,  nullable=false, length=20)
     */
    public $phoneNumber;

    /**
     * @var string
     * @ORM\Column(type="string", name="country_code", length=2)
     */
    public $countryCode;

    /**
     * @var string
     * @ORM\Column(type="string", name="timezone_name", length=20)
     */
    public $timezoneName;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", name="inserted_on", options={"default": "CURRENT_TIMESTAMP"})
     */
    public $insertedOn;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", name="updated_on", options={"default": "CURRENT_TIMESTAMP"})
     */
    public $updatedOn;

    /*
     * First name (required)
    Last name
    Phone number (required) - must be validated based on some standard, e.g. +12 223 444224455
    Country code - country code should be validated via https://api.hostaway.com/countries
    Timezone name - should be validated via https://api.hostaway.com/timezones
    insertedOn (required) - DateTime type
    updatedOn (required) - DateTime type

     */
    /**
     * @param array $arguments
     * @return static
     */
    public static function create($arguments = [])
    {
        $instance = new static();
        foreach ($arguments as $key => $value) {
            $instance->{$key} = $value;
        }
        return $instance;
    }

}