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

if (!function_exists('setIsValidField')) {
    function setIsValidField(string $field, $errors): string
    {
        return $errors->has($field)
            ? ' is-invalid'
            : ($errors->count() > 0 ? ' is-valid' : '');
    }
}
