<?php
namespace AvangateSmartApiClient\Module\Exception;

class InvalidArgumentException extends \InvalidArgumentException
{
    const NO_DEFAULT_CURRENCY = 1;
    const NO_DEFAULT_LANGUAGE = 2;
    const NO_VALID_ORDER_INSTANCE = 3;
}