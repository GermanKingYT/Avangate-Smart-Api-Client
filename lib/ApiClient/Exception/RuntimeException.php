<?php
namespace AvangateSmartApiClient\ApiClient\Exception;

class RuntimeException extends \RuntimeException
{
    const EMPTY_SESSION_ID = 4;
    const API_CLIENT_LOGIN_FAILED = 6;
}