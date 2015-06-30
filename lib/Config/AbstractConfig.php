<?php
namespace AvangateSmartApiClient\Config;

abstract class AbstractConfig implements ConfigInterface
{
    protected $config = array();

    public function add($key, $value)
    {
        $this->config[$key] = $value;
    }

    public function get($key)
    {
        return isset($this->config[$key]) ? $this->config[$key] : null;
    }

    public function getAsArray()
    {
        return $this->config;
    }
}