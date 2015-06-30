<?php
namespace AvangateSmartApiClient\Transport;

abstract class AbstractTransport implements TransportInterface
{
    protected $proxy;
    protected $request;
    protected $response;

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

    abstract public function connect();
    abstract public function send($method, $url, $body);
    abstract public function read();
    abstract public function close();
}