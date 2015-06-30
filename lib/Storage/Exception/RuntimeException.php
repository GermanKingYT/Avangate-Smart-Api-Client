<?php
namespace AvangateSmartApiClient\Storage\Exception;

class RuntimeException extends \RuntimeException
{
    const STORAGE_FATAL_ERROR = 1;
    const NO_LANGUAGES_FOUND = 2;
}