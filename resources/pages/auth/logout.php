<?php

use Classes\Login;

$oldUrl = $_SERVER['HTTP_REFERER'];

if(!str_contains($oldUrl, '/login') && !str_contains($oldUrl, '/logout')){
    $_SESSION['oldUrl'] = $oldUrl;
}

Login::logout();