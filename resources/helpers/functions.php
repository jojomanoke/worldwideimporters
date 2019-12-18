<?php

/**
 * This is a debug function to dump and die a variable or function
 */
if(!function_exists('dd')) {
    function dd()
    {
        
        foreach(func_get_args() as $variable) {
            echo '<pre style="background-color: lightgray">';
            var_dump($variable);
            echo '</pre>';
        }
        exit();
    }
}

/**
 * Gets the current url
 */
if(!function_exists('getUrl')) {
    function getUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }
}

/**
 * Compares the current url with the $url or returns the current url when $url is null
 */
if(!function_exists('activeUrl')) {
    /**
     * @param null $url // The url to check
     * @return bool|mixed
     */
    function activeUrl($url = null)
    {
        $currentUrl = $_SERVER['REQUEST_URI'];
        if(!$url) {
            return $currentUrl;
        }
        
        return $currentUrl === $url;
    }
}

/**
 * Checks if a string contains something
 */
if(!function_exists('str_contains')) {
    /**
     * @param $haystack string String to search
     * @param $needle string String to find
     * @return bool
     */
    function str_contains($haystack, $needle)
    {
        return substr_count($haystack, $needle);
    }
}

/**
 * Translates a string
 */
if(!function_exists('trans')) {
    /**
     * @param $translationString string The translation to get
     * Sent as file.translation
     * @return mixed|string
     */
    function trans($translationString /* Translation to get */)
    {
        $explodedString = explode('.', $translationString);
        $translationFile = SERVER_ROOT . '/resources/lang/' . env('LANGUAGE') . "/$explodedString[0].php";
        if(!file_exists($translationFile)) {
            return ucfirst($explodedString[count($explodedString) - 1]);
        }
        $translations = include($translationFile);
        if(!str_contains($translationString, '.')) {
            return $translations[$translationString] ?? $translationString;
        }
        if(!$translations[$explodedString[1]]) {
            return ucfirst($explodedString[1]);
        }
        if(substr_count($translationString, '.') > 1) {
            $pointCount = substr_count($translationString, '.');
            $translation = $translations;
            for($i = 1; $i <= $pointCount; $i++) {
                
                if(array_key_exists($explodedString[$i], $translation)){
                    $translation = $translation[$explodedString[$i]];
                } else {
                    $translation = $explodedString[(count($explodedString) - 1)];
                }
            }
            return $translation;
        }
        return $translations[$explodedString[1]];
    }
}

if(!function_exists('env')) {
    function env($environmentVariable, $default = null)
    {
        if(!file_exists(SERVER_ROOT . '/.env')) {
            return trim($default);
        }
        
        if(!getenv($environmentVariable)) {
            return trim($default);
        }
        
        return trim(getenv($environmentVariable));
    }
}

if(!function_exists('session')) {
    function session($key = null)
    {
        return $key ? $_SESSION[$key] : $_SESSION;
    }
}

if(!function_exists('redirect')) {
    function redirect($url = null)
    {
        echo ('<script>window.location.href = "' . $url ?? activeUrl() . '</script>');
    }
}

if(!function_exists('getBlob')) {
    function getBlob($blob)
    {
        $type = 'image/png'; //or the actual mime type of the file
        $base64blob = base64_encode($blob); //encode to base64
        return "data:$type;base64,$base64blob";
    }
}

if(!function_exists('resizeImage')) {
    function resizeImage($imageWidth, $imageHeight, $maxWidth, $maxHeight)
    {
        $imageSize['width'] = $imageWidth;
        $imageSize['height'] = $imageHeight;
        if($imageWidth > $maxWidth || $imageHeight > $maxHeight) {
            if($imageWidth > $imageHeight) {
                $imageSize['height'] = floor(($imageHeight / $imageWidth) * $maxWidth);
                $imageSize['width'] = $maxWidth;
            } else {
                $imageSize['width'] = floor(($imageWidth / $imageHeight) * $maxHeight);
                $imageSize['height'] = $maxHeight;
            }
        }
        return $imageSize;
    }
}

if(!function_exists('post')) {
    function post($postKey)
    {
        return $_POST[$postKey] ?? null;
    }
}

if(!function_exists('old')) {
    function old($key, $default = '')
    {
        return $_POST[$key] ?? $default;
    }
}

if(!function_exists('filterQuery')) {
    function filterQuery(string $query)
    {
        $filters = [];
        foreach($_GET as $key => $item){
            if(is_array($item)){
                foreach($item as $iteration => $id) {
                    $item[$iteration] = addslashes($id);
                }
                $filters[$key] = $item;
            } else {
                $filters[$key] = addslashes($item);
            }
        }
        if(isset($filters['color'])) {
            if(str_contains($query, 'WHERE')){
                $query .= ' AND';
            } else {
                $query .= ' WHERE';
            }
            $query .= ' ColorID IN ('. implode(', ', $filters['color']) . ')';
        }
        
        if(isset($filters['size'])){
            if(str_contains($query, 'WHERE')){
                $query .= ' AND';
            } else {
                $query .= ' WHERE';
            }
            $query .= ' Size IN (\''.implode(', ', $filters['size']).'\')';
        }
    
    
        if(isset($filters['brand'])){
            if(str_contains($query, 'WHERE')){
                $query .= ' AND';
            } else {
                $query .= ' WHERE';
            }
            $query .= ' Brand IN (\''.implode(', ', $filters['brand']).'\')';
        }
        
        if(isset($filters['priceFilter'])) {
            $query .= ' ORDER BY UnitPrice';
            if($filters['priceFilter'] === 'hooglaag') {
                $query .= ' DESC';
            }
        }
        return $query;
    }
}

if(!function_exists('url')) {
    function url($url)
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]/$url/";
    }
}