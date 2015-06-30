<?php
namespace AvangateSmartApiClient\Transport;

use GuzzleHttp;

class HttpTransportAdapter implements TransportAdapterInterface
{
    protected $client;
    protected $proxy;
    protected $request;
    protected $response;

    public function __construct(GuzzleHttp\Client $client)
    {
        $this->client = $client;
    }

    public function setProxy($proxy)
    {
        $this->proxy = $proxy;
    }

    public function getProxy()
    {
        return $this->proxy;
    }

    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setResponse($response)
    {
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
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