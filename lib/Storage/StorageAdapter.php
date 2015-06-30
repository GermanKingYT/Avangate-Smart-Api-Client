<?php
namespace AvangateSmartApiClient\Storage;
use AvangateSmartApiClient\Config;

/**
 * Class AbstractStorage
 * @package AvangateSmartApiClient\Storage
 */
abstract class StorageAdapter implements StorageAdapterInterface
{
    protected $config;
    /**
     * Prefix is used to generate unique
     * memcache entries per vendor.
     *
     * @var string
     */
    protected $keysPrefix = null;


    public function __construct(Config\ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function setKeysPrefix($keysPrefix)
    {
        $this->keysPrefix = $keysPrefix;
    }

    public function getKeysPrefix()
    {
        return $this->keysPrefix;
    }

    /**
     * Prepare the final key name, how it is stored
     * in the chosen Storage to avoid keys collisions.
     *
     * @param string $key
     * @return string
     */
    public function prepareKey($key)
    {
        return $this->getKeysPrefix() . '_' . $key;
    }

    /**
     * Returns the value associated to the input key.
     *
     * @param  string $key
     * @return mixed
     */
    abstract public function get($key);

    /**
     * Set the key-value pair
     * @param string $key
     * @param mixed $value
     */
    abstract public function set($key, $value);

    /**
     * Deletes the key from the storage.
     * Depending on the storage system
     * we might NULLify the value of the key.
     *
     * @param string $key
     */
    abstract public function delete($key);

    /**
     * Deletes all key-value pairs.
     */
    abstract public function destroy();
}
