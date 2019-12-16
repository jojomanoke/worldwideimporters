<?php


namespace Classes;


use Classes\Query\Query;

/**
 * Autocomplete for editors
 *
 * Class Auth
 * @package Classes
 *
 * @property int UserID
 * @property string FirstName
 * @property string Infix
 * @property string LastName
 * @property string Email
 * @property int GenderID
 * @property int PhoneNumber
 * @property string ZipCode
 * @property string Address
 * @property int CountryID
 * @property string City
 * @property int HouseNumber
 * @property string Addition
 *
 */

class Auth
{
    public static function user(): Auth
    {
        if(!isset($_SESSION['userSession'])) {
            return new self();
        }
        
        return self::convertToAuthObject(Query::get('users')->where('UserID', $_SESSION['userSession'][2]));
    }
    
    public static function id(): int
    {
        if(!self::user()) {
            return 0;
        }
        
        return (self::user())->UserID;
    }
    
    /**
     * recast stdClass object to an object of a type
     *
     * @param mixed $object
     * @return mixed new, typed object
     * @throws \InvalidArgumentException
     */
    private static function convertToAuthObject($object)
    {
        $newCollection = new self();
        
        foreach($object as $property => &$value) {
            $newCollection->$property = &$value;
            unset($object->$property);
        }
        unset($value);
        return $newCollection;
    }
}