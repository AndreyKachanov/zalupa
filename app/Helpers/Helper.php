<?php

if (!function_exists('generateToken')) {
    function generateToken(): string
    {
        return md5(rand(1, 10) . microtime());
    }
}

if (!function_exists('myCacheFunction')) {
    function myCacheFunction($name, $callback)
    {
        static $cache = [];

        if(isset($cache[$name])) return $cache[$name];
        return $cache[$name] = $callback();
    }
}


