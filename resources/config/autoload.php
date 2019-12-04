<?php

/**
 * Laad classes automatisch zodat er bovenaan de index.php niet elke keer ---include('/resources/classes/ClassName.php')
 * geschreven hoeft te worden
 */
spl_autoload_register(static function ( $className ) {
    $className = ltrim($className, '\\');
    $fileName = SERVER_ROOT.'/resources/';
    if ( $lastNsPos = strrpos($className, '\\') ) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName .= str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    require $fileName;
});