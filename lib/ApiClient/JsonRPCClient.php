<?php
namespace AvangateSmartApiClient\ApiClient;

use AvangateSmartApiClient\Storage;
use AvangateSmartApiClient\Transport;

class JsonRPCClient extends AbstractApiClient
{
    protected $sessionKey;

    protected $apiClientConfig;
    /**
     * @var Storage\StorageManager
     */
    protected $storageManager;
    /**
     * @var Transport\TransportAdapterInterface
     */
    protected $transportAdapter;

    private $totalCalls = 0;
    private $loginAttempts = 0;

    public function __construct(ApiClientConfig $apiClientConfig)
    {
        $this->apiClientConfig = $apiClientConfig;
    }

    public function send($methodName, $args)
    {
        if (!$this->apiClientConfig->getEndpointUrl()) {
            throw new Exception\InvalidArgumentException(
                'The URL of the endpoint is not set.',
                Exception\InvalidArgumentException::EMPTY_ENDPOINT_URL
            );
        }

        if (!$this->apiClientConfig->getMerchantCode()) {
            throw new Exception\InvalidArgumentException(
                'The merchant code is not set.',
                Exception\InvalidArgumentException::EMPTY_MERCHANT_CODE
            );
        }

        // Compose the request.
        $request = new \stdClass();
        $request->jsonrpc = '2.0';
        $request->id      = $this->totalCalls++;
        $request->method  = $methodName;
        $request->params  = $args;

        // Prepare the request body.
        $body = json_encode($request);

        // Send the request.
        return $this->transportAdapter->send('POST', $this->getEndpointUrl(), $body);
    }

    /**
     * Reads the remote response.
     *
     * @return bool|mixed
     * @throws Exception\RequestException
     */
    public function read()
    {
        $originalResponse = $this->transportAdapter->read();

        //exit($originalResponse->getBody());

        // Translate the response and return it.
        $response = json_decode($originalResponse->getBody());

        // Is it a valid json response?
        $lastJsonError = json_last_error();
        if($lastJsonError) {
            throw new Exception\RequestException(
                'JSON decoding of the HTTP response body has failed.',
                Exception\RequestException::JSON_REQUEST_ERROR
            );
        }

        if (isset($response->error)) {
            throw new Exception\RequestException(
                $response->error->message,
                $response->error->code,
                $response->error->data
            );
        }

        if (isset($response->result)) {
            return $response->result;
        } else {
            return false;
        }
    }

    public function login()
    {
        $now    = date('Y-m-d H:i:s');
        $string = strlen($this->getMerchantCode()) . $this->getMerchantCode() . strlen($now) . $now;
        $hash   = hash_hmac('md5', $string, $this->getEndpointPassword());

        // Reset total calls.
        $this->totalCalls = 0;

        $requestArgs = array($this->getMerchantCode(), $now, $hash);
        $this->send('login', $requestArgs);
        $serviceSessionId = $this->read();

        if (!empty($serviceSessionId)) {
            // Store the current session id in the storage.
            // The name of the key is the name of the current class. Eg: 'JsonRPC'
            $this->storageManager->getStorage()->set($this->getSessionKey(), $serviceSessionId);
        } else {
            throw new Exception\RuntimeException(
                'The session id returned by the login is empty.',
                Exception\RuntimeException::EMPTY_SESSION_ID
            );
        }

        // Increment the login attempts.
        $this->loginAttempts++;

        return $serviceSessionId;
    }

    /**
     * @param $methodName
     * @param $args
     * @return bool|mixed
     * @throws Exception\RequestException
     * @throws \Exception
     */
    public function __call($methodName, $args)
    {
        if (substr($methodName, 0, 5) != 'call_') {
            throw new Exception\BadMethodCallException(
                sprintf('No such method exists [%s].', $methodName),
                Exception\BadMethodCallException::INVALID_API_CLIENT_METHOD_NAME
            );
        }

        // Get the _real_ API method name.
        $realMethodName = substr($methodName, 5);

        // Login if we're not already authenticated.
        $serviceSessionId = $this->storageManager->getStorage()->get($this->getSessionKey());

        // Login if we're not already authenticated.
        if (empty($serviceSessionId)) {
            $serviceSessionId = $this->login();
        }

        // Prepend the session id.
        array_unshift($args, $serviceSessionId);
        $this->send($realMethodName, $args);

        try {
            $response = $this->read();
            return $response;
        } catch (Exception\RequestException $e) {
            // Re-login if it's an authentication problem.
            if (in_array($e->getCode(), array($e::FORBIDDEN, $e::INVALID_SESSION))) {
                // Delete the old session id from Storage.
                $this->storageManager->getStorage()->delete($this->getSessionKey());

                // Don't re-login if the number of maximum o re-logins was reached.
                if ($this->loginAttempts > 1) {
                    throw new Exception\RuntimeException(
                        'Could not login. Maximum number of logins reached.',
                        Exception\RuntimeException::API_CLIENT_LOGIN_FAILED,
                        $e
                    );
                }

                $this->loginAttempts++;

                // Call again the method.
                // Remove the session id. It's prepended inside the method again.
                array_shift($args);
                return $this->{__FUNCTION__}($methodName, $args);
            }

            // Finally throw the exception if there is a problem with the response.
            throw $e;

        }
    }

    public function logout()
    {

    }

}
