<?php
namespace AvangateSmartApiClient\Config;

interface ConfigInterface
{
    public function add($key, $value);
    public function get($key);
    public function getAsArray();
}