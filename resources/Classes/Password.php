<?php


namespace Classes;

class Password
{
    public static function verify(): bool
    {
        /** @var array $data The variable to store the POST data in */
        $data = [];
        $connection = Database::getConnection();
        $data['gender'] = addslashes($_POST['gender']);
        $data['firstName'] = addslashes($_POST['firstName']);
        $data['infix'] = isset($_POST['infix']) ? addslashes($_POST['infix']) : ''; // Tussenvoegsel
        $data['lastName'] = addslashes($_POST['lastName']);
        $data['phoneNumber'] = addslashes($_POST['phoneNumber']);
        $data['city'] = addslashes($_POST['city']);
        $data['address'] = addslashes($_POST['address']);
        $data['houseNumber'] = addslashes($_POST['houseNumber']);
        $data['addition'] = addslashes($_POST['addition']) ?? '';
        $data['zipCode'] = addslashes($_POST['zipCode']);
        $data['email'] = strtolower(addslashes($_POST['email']));
        $data['password'] = addslashes($_POST['password']);
        $data['passwordConfirm'] = addslashes($_POST['passwordConfirm']);
        
        $errors = self::makeErrors($data);
        
        if(count($errors)) {
            $_SESSION['errors'] = $errors;
            return false;
        }
        
        
        $stmt = $connection->prepare('INSERT INTO users (
                        GenderID,
                        FirstName,
                        Infix,
                        LastName,
                        PhoneNumber,
                        City,
                        Address,
                        HouseNumber,
                        Addition,
                        ZipCode,
                        Email,
                        Password
                        )
                        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )');
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt->bind_param('isssississss',
            $data['gender'],
            $data['firstName'],
            $data['infix'],
            $data['lastName'],
            $data['phoneNumber'],
            $data['city'],
            $data['address'],
            $data['houseNumber'],
            $data['addition'],
            $data['zipCode'],
            $data['email'],
            $data['password']
        );
        
        
        if(!count($errors)) {
            $stmt->execute();
            Login::login();
            return false;
        }
        
        return true;
    }
    
    /**
     * This function returns the errors.
     * Will check all data for errors and null values
     * @TODO: Meer errors implementeren
     * @param array $data
     * @return array
     */
    private static function makeErrors(array $data): array
    {
        $errors = [];
        foreach($data as $key => $item) {
            if(!isset($item) && $key !== 'passwordConfirm') {
                $errors[] = $key;
            }
        }
        if($data['password'] !== $data['passwordConfirm']) {
            $errors[] = 'passwordVerify';
        }
        
        return $errors;
    }
}