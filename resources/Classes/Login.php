<?php


namespace Classes;


use Classes\Query\Query;

class Login
{
    public static function login()
    {
        $email = $_POST['email'];
        $hashedEmail = hash('md5', $email);
        $user = Query::get('users')->where('Email', $email)->first();
        $_SESSION['userSession'] = [$email, $hashedEmail, $user->UserID];
        $URL= '/home';
        echo "<script type='text/javascript'>window.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
    
    public static function isLoggedIn(): bool
    {
        $user = $_SESSION[ 'userSession' ] ?? false;
        
        if(!$user) return false;
        if(hash_equals(hash('md5', $user[0]), $user[1])){
            return true;
        }
        
        return false;
    }
    
    public static function logout() {
        unset($_SESSION['userSession']);
        $URL= '/home';
        echo "<script type='text/javascript'>window.location.href='{$URL}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
    }
    
    public static function id(): int
    {
        if(self::isLoggedIn()){
            return $_SESSION['userSession'][2];
        }
        return 0;
    }
}