<?php
namespace AvangateSmartApiClient\Storage;

use AvangateSmartApiClient\Config;
use AvangateSmartApiClient\Functions;

/**
 * Storage engine based on JSON files
 * Requires that the storage path be set.
 */
class FileStorageAdapter extends StorageAdapter
{
    protected $storageAdapterConfig;

    /**
     * @param FileStorageAdapterConfig $storageAdapterConfig
     */
    public function __construct(FileStorageAdapterConfig $storageAdapterConfig)
    {
        $this->storageAdapterConfig = $storageAdapterConfig;

        $this->system = new Functions\SystemFunctions();
        $this->functions = new Functions\UtilityFunctions();

        if (!$this->system->is_dir($this->storageAdapterConfig->getPath())) {
            throw new Exception\RuntimeException(
                sprintf('The storage path is an invalid folder [%s].', $this->storageAdapterConfig->getPath()),
                Exception\RuntimeException::STORAGE_FATAL_ERROR
            );
        }

        if (!$this->system->is_writable($this->storageAdapterConfig->getPath())) {
            throw new Exception\RuntimeException(
                sprintf('The storage path is not writable [%s].', $this->storageAdapterConfig->getPath()),
                Exception\RuntimeException::STORAGE_FATAL_ERROR
            );
        }
    }

    public function prepareKey($key)
    {
        return $this->getKeysPrefix() . '_' . str_replace('\\', '__', $key);
    }

    /**
     * Saves the data in the input file.
     *
     * @param $file
     * @param $content  string JSON with encoded values
     * @return bool
     * @throws Exception\RuntimeException   If the permissions to read / write / create the file are not properly set.
     */
    private function writeToFile($file, $content)
    {
        if (!$handle = $this->system->fopen($file, 'w')) {
            throw new Exception\RuntimeException(
                sprintf('Not enough permissions to create or open [%s].', $file),
                Exception\RuntimeException::STORAGE_FATAL_ERROR
            );
        }

        if ($this->system->fwrite($handle, $content) === false) {
            throw new Exception\RuntimeException(
                sprintf('The file [%s] is not writable.', $file),
                Exception\RuntimeException::STORAGE_FATAL_ERROR
            );
        }

        $this->system->fclose($handle);

        return true;
    }

    /**
     * Reads the contents of the file and returns them.
     * Returns false if the file does not exist.
     * @param  string $file
     * @return string|bool
     * @throws Exception\RuntimeException If the file is not readable
     */
    private function readFile($file)
    {
        if (!$this->system->file_exists($file)) {
            return null;
        }

        // @todo: check why do we care about this (?)
        if(!$this->system->is_writable($file)){
            throw new Exception\RuntimeException(
                sprintf('The file [%s] is not writable.', $file),
                Exception\RuntimeException::STORAGE_FATAL_ERROR
            );
        }

        if (!$handle = $this->system->fopen($file, "r")) {
            throw new Exception\RuntimeException(
                sprintf('The file [%s] is not readable.', $file),
                Exception\RuntimeException::STORAGE_FATAL_ERROR
            );
        }

        $this->system->clearstatcache();
        $filesize = $this->system->filesize($file);

        if (!$filesize) {
            return null;
        }

        $contents = $this->system->fread($handle, $filesize);
        $this->system->fclose($handle);

        return $contents;
    }

    /**
     * Deletes the file.
     * @param $file
     * @return bool
     */
    private function deleteFile($file)
    {
        return $this->system->unlink($file);
    }

    /**
     * Returns the value stored in the key-value pair.
     * @param string $key
     * @return mixed
     * @throws Exception\RuntimeException
     */
    public function get($key)
    {
        $fileContent = $this->readFile($this->storageAdapterConfig->getPath() . $this->prepareKey($key));
        $result = json_decode($fileContent);

        $lastJsonError = json_last_error();
        if($lastJsonError) {
            throw new Exception\RuntimeException(
                sprintf('Decoding storage file failed. [%d] [%s] ', $lastJsonError, json_last_error_msg()),
                Exception\RuntimeException::STORAGE_FATAL_ERROR
            );
        }

        return $result;
    }

    /**
     * Set the key-value pair.
     * @param string $key
     * @param mixed $value
     * @param int $expire
     * @return bool
     */
    public function set($key, $value, $expire = 0)
    {
        $set = $this->writeToFile($this->storageAdapterConfig->getPath() . $this->prepareKey($key), json_encode($value)); // , (int)JSON_PRETTY_PRINT

        // Keep track of the cache keys.
        // Because we need to destroy them later.
        if($set && $key != 'allKeys'){
            $allKeys = $this->get('allKeys');
            //var_dump($allKeys);
            //echo "\n";

            $has_key = $this->functions->count($allKeys);
            $is_obj = is_object($allKeys);
            if(!$is_obj && $has_key <= 0){
                $allKeys = new \stdClass;
            }
            $allKeys->{$key} = array(
                'dateInsert' => time(),
                'dateExpire' => time() + $expire
            );

            $this->set('allKeys', $allKeys);
        }

        return $set;
    }

    /**
     * Delete the key from disk.
     * @see \Acart\Storage\AbstractStorage::delete()
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        if(empty($key)){
            return false;
        }

        return $this->deleteFile($this->storageAdapterConfig->getPath() . $this->prepareKey($key));
    }

    /**
     * Deletes all stored files.
     */
    public function destroy()
    {
        $dir = $this->system->getDirectoryIterator($this->storageAdapterConfig->getPath());

        if (count($dir)) {
            foreach ($dir as $fileInfo) {
                if (!$fileInfo->isDot()) {
                    $this->deleteFile($this->storageAdapterConfig->getPath() . $fileInfo->getFilename());
                }
            }
        }
    }
}
