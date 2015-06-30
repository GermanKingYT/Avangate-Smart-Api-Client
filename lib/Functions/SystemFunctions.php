<?php
namespace AvangateSmartApiClient\Functions;

/**
 * Class System
 * @package AvangateSmartApiClient
 */
class SystemFunctions {

    public function is_dir($folder_path)
    {
        return is_dir($folder_path);
    }

    public function fopen($file, $mode = "r")
    {
        return fopen($file, $mode);
    }

    public function fwrite($handle, $content)
    {
        return fwrite($handle, $content);
    }

    public function file_exists($file_path)
    {
        return file_exists($file_path);
    }

    public function is_writable($file_path)
    {
        return is_writable($file_path);
    }

    public function filesize($file_path)
    {
        return filesize($file_path);
    }

    public function fread($file_path, $filesize)
    {
        return fread($file_path, $filesize);
    }

    public function fclose($handle)
    {
        return fclose($handle);
    }

    public function clearstatcache()
    {
        return \clearstatcache();
    }

    public function unlink($file_path)
    {
        return unlink($file_path);
    }

    public function class_exists($class_name)
    {
        return class_exists($class_name);
    }

    public function session_start()
    {
        return \session_start();
    }

    public function session_destroy()
    {
        return \session_destroy();
    }

    /**
     * @param $path
     * @return \DirectoryIterator
     */
    public function getDirectoryIterator($path)
    {
        return new \DirectoryIterator($path);
    }
}