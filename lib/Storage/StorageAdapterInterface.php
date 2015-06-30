<?php
namespace AvangateSmartApiClient\Storage;

interface StorageAdapterInterface
{
    public function setKeysPrefix($keysPrefix);
    public function getKeysPrefix();
    public function get($key);
    public function set($key, $value);
    public function delete($key);
    public function destroy();
}