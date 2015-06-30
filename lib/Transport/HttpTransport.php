<?php
namespace AvangateSmartApiClient\Transport;

use GuzzleHttp\Client;

class HttpTransport extends AbstractTransport
{
    protected $client;
    protected $request;
    protected $response;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function connect()
    {

    }

    public function send($method, $url, $body = null)
    {
        $request = $this->client->createRequest($method, $url, array(
                'body' => $body,
                'proxy' => false,
                // Disable cookies when connecting to Product and Order APIs.
                'cookies' => false
            )
        );
        $this->setRequest($request);
        try {
            $response = $this->client->send($request);
            $this->setResponse($response);
            return true;
        } catch(\Exception $e) {
            print_r($e);
        }
    }

    public function read()
    {
        return $this->response;
    }

    public function close()
    {

    }
}