<?php

/**
 * This is a debug function to dump and die a variable or function
 */
if ( !function_exists('dd') ) {
    /**
     * @param $variable // The variable to dump
     */
    function dd( $variable )
    {
        echo '<pre>';
        var_dump($variable);
        echo '</pre>';
        exit();
    }
}

/**
 * Gets the current url
 */
if ( !function_exists('getUrl') ) {
    function getUrl()
    {
        return $_SERVER[ 'REQUEST_URI' ];
    }
}

/**
 * Compares the current url with the $url or returns the current url when $url is null
 */
if ( !function_exists('activeUrl') ) {
    /**
     * @param null $url // The url to check
     * @return bool|mixed
     */
    function activeUrl( $url = null )
    {
        $currentUrl = $_SERVER[ 'REQUEST_URI' ];
        if ( !$url ) {
            return $currentUrl;
        }
        
        return $currentUrl === $url;
    }
}

/**
 * Checks if a string contains something
 */
if ( !function_exists('str_contains') ) {
    /**
     * @param $haystack string String to search
     * @param $needle string String to find
     * @return bool
     */
    function str_contains( $haystack, $needle )
    {
        return (bool)strpos($haystack, $needle);
    }
}

/**
 * Translates a string
 */
if ( !function_exists('trans') ) {
    /**
     * @param $translationString string The translation to get
     * Sent as file.translation
     * @return mixed|string
     */
    function trans( $translationString /* Translation to get */ )
    {
        $explodedString = explode('.', $translationString);
        $translationFile = SERVER_ROOT . '/resources/lang/' . env('LANGUAGE') . "/$explodedString[0].php";
        if ( !file_exists($translationFile) ) {
            return ucfirst($explodedString[ count($explodedString) - 1 ]);
        }
        $translations = include( $translationFile );
        if ( !str_contains($translationString, '.') ) {
            return $translations[ $translationString ];
        }
        if ( !$translations[ $explodedString[ 1 ] ] ) {
            return ucfirst($explodedString[ 1 ]);
        }
        if ( substr_count($translationString, '.') > 1 ) {
            $pointCount = substr_count($translationString, '.');
            $translation = $translations;
            
            for ( $i = 1; $i <= $pointCount; $i++ ) {
                $translation = $translation[ $explodedString[ $i ] ];
            }
        }
        return $translations[ $explodedString[ 1 ] ];
    }
}

if( !function_exists('env') ){
    function env($environmentVariable, $default = null){
        if(!file_exists(SERVER_ROOT . '/.env')){
            return trim($default);
        }
        
        if(!getenv($environmentVariable)) {
            return trim($default);
        }
        
        return trim(getenv($environmentVariable));
    }
}

if( !function_exists('session')){
    function session($key = null) {
        return $key ? $_SESSION[$key] : $_SESSION;
    }
}

if( !function_exists('redirect')){
    function redirect($url = null) {
        header('Location: ' . $url ?? activeUrl());
    }
}