<?php
namespace AvangateSmartApiClient\ApiClient\Exception;

/**
 * Class handles the remote error response
 * and maps it to our needs.
 *
 * Example of remote error object response:
 * <code>
 *   object(stdClass)#26 (3) {
 *       ["code"]=>
 *           int(10000)
 *       ["message"]=>
 *           string(40) "Invalid hash provided or session expired"
 *       ["data"]=>
 *           object(stdClass)#37 (1) {
 *       ["error_code"]=>
 *           string(9) "FORBIDDEN"
 *       }
 *   }
 * </code>
 *
 * @package Acart\ApiClient
 */
class RequestException extends \Exception
{
    /**
     * Remote error codes.
     */

    /**
     * Login related error codes.
     */
    const FORBIDDEN = 10000;
    const INVALID_SESSION = 10001;
    const SESSION_EXPIRED = 10002;
    const NOT_ALLOWED = 10004;
    const DEPRECATED = 11000;

    /**
     * Order related error codes.
     */
    const ORDER_ERROR = 55201;
    const CARD_ERROR = 40240;

    const PAYMENT_ERROR = 55200;

    // Local errors.
    const JSON_REQUEST_ERROR = 3;

    protected $data;

    public function __construct($message, $code, $data = null, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}