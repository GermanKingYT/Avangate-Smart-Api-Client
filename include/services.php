<?php

/**
 * @param $c Illuminate\Container\Container
 * @return $config array
 */
$c->bindShared('config', function($c) {
    return include 'config.php';
});
