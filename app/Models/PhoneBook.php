<?php


namespace App\Models;

/**
 * Class PhoneBook
 * @package App\Models
 */
class PhoneBook
{
    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string
     */
    public $phoneNumber;

    /**
     * @var string
     */
    public $countryCode;

    /**
     * @var string
     */
    public $timezoneName;

    /**
     * @var \DateTime
     */
    public $insertedOn;

    /**
     * @var \DateTime
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

}