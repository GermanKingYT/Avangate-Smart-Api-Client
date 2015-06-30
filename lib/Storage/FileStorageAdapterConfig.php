<?php
namespace AvangateSmartApiClient\Storage;

use AvangateSmartApiClient\Config;

class FileStorageAdapterConfig extends Config\AbstractConfig implements Config\ConfigInterface
{
    protected $path;

    public function setPath($path)
    {
        $path = rtrim($path, '/') . '/';
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }
}