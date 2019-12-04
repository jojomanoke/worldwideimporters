<?php


namespace Classes;


use Classes\Query\Query;

class Auth
{
    public static function user() {
        if(!isset($_SESSION['userSession'])){
            return false;
        }
        
        $userQuery = Query::get('users')->where('UserID', $_SESSION['userSession'][2]);
        return self::convertToAuthObject($userQuery);
    }
    
    public static function id(){
        if(!self::user()){
            return false;
        }
        
        return (self::user())->UserID;
    }
    
    /**
     * recast stdClass object to an object of a type
     *
     * @param \stdClass $object
     * @return mixed new, typed object
     * @throws \InvalidArgumentException
     */
    private static function convertToAuthObject( \stdClass $object )
    {
        $newCollection = new self();
        
        foreach ( $object as $property => &$value ) {
            $newCollection->$property = &$value;
            unset($object->$property);
        }
        unset($value);
        return $newCollection;
    }
}