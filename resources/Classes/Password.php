<?php


namespace Classes;

class Password
{
    public static function verify(): bool
    {
        /** @var array $data The variable to store the POST data in */
        $data = [];
        $connection = Database::getConnection();
        $data['gender'] = $_POST['gender'] ?? null;
        $data['firstName'] = $_POST['firstName'] ?? null;
        $data['infix'] = $_POST['infix'] ?? ''; // Tussenvoegsel
        $data['lastName'] = $_POST['lastName'] ?? null;
        $data['country'] = $_POST['country'] ?? null;
        $data['phoneNumber'] = $_POST['phoneNumber'] ?? null;
        $data['city'] = $_POST['city'] ?? null;
        $data['address'] = $_POST['address'] ?? null;
        $data['houseNumber'] = $_POST['houseNumber'] ?? null;
        $data['addition'] = $_POST['addition'] ?? '';
        $data['zipCode'] = $_POST['zipCode'] ?? null;
        $data['email'] = $_POST['email'] ?? null;
        $data['password'] = $_POST['password'] ?? null;
        $data['passwordConfirm'] = $_POST['passwordConfirm'] ?? null;
        
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
                        CountryID,
                        PhoneNumber,
                        City,
                        Address,
                        HouseNumber,
                        Addition,
                        ZipCode,
                        Email,
                        Password
                        )
                        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )');
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt->bind_param('isssiississss',
            $data['gender'],
            $data['firstName'],
            $data['infix'],
            $data['lastName'],
            $data['country'],
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