<?php
/**
 * In here the global variables will be defined like the language, name of the website and the root of the server
 */

/**
 * Server root
 */
define('SERVER_ROOT', $_SERVER[ 'DOCUMENT_ROOT' ]);

/**
 * Defines the environment variables
 */
$envFile = file_get_contents(SERVER_ROOT . '/.env');
$envVars = explode("\n", $envFile);
foreach($envVars as $var) {
    putenv($var);
}