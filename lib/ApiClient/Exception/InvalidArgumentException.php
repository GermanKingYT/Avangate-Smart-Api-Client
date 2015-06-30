<?php
namespace AvangateSmartApiClient\ApiClient\Exception;

class InvalidArgumentException extends \InvalidArgumentException
{
    const EMPTY_ENDPOINT_URL = 0;
    const EMPTY_MERCHANT_CODE = 1;
    const NO_VALID_ORDER_INSTANCE = 2;
}