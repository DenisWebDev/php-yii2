<?php
    if (!function_exists('_d')) {
        function _d($v) {
            echo '<pre>';
            if (is_bool($v) or is_null($v)) {
                var_dump($v);
            } else {
                print_r($v);
            }
            echo '</pre>';
        }
    }