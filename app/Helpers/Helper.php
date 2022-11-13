<?php

    if (!function_exists('generateToken')) {
        function generateToken() {
            return md5(rand(1, 10) . microtime());
        }
    }
