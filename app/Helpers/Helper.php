<?php

if (!function_exists('generateToken')) {
    function generateToken(): string
    {
        return md5(rand(1, 10) . microtime());
    }
}
