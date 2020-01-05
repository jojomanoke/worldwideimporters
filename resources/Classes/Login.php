<?php


namespace Classes;


use Classes\Query\Query;

class Login
{
    public static function login(): void
    {
        $email = strtolower($_POST['email']);
        $hashedEmail = hash('md5', $email);
        $user = Query::get('users')->where('Email', $email)->first();
        $_SESSION['userSession'] = [$email, $hashedEmail, $user->UserID];
        if(isset($_SESSION['oldUrl'])) {
            $url = $_SESSION['oldUrl'];
            unset($_SESSION['oldUrl']);
        } else {
            $url = $_SESSION['oldUrl'] ?? '/home';
        }
        echo "<script type='text/javascript'>window.location.href='{$url}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $url . '">';
        exit();
    }
    
    public static function isLoggedIn(): bool
    {
        if(!isset($_SESSION['userSession'])) {
            return false;
        }
        $user = $_SESSION['userSession'];
        if(hash_equals(hash('md5', $user[0]), $user[1])) {
            return true;
        }
        
        return false;
    }
    
    public static function logout(): void
    {
        unset($_SESSION['userSession']);
        if(isset($_SESSION['oldUrl'])) {
            $url = $_SESSION['oldUrl'];
            unset($_SESSION['oldUrl']);
        } else {
            $url = $_SESSION['oldUrl'] ?? '/home';
        }
        echo "<script type='text/javascript'>window.location.href='{$url}';</script>";
        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $url . '">';
    }
    
    public static function id(): int
    {
        if(self::isLoggedIn()) {
            return $_SESSION['userSession'][2];
        }
        return 0;
    }
}