<?php
namespace AvangateSmartApiClient\Transport;

interface TransportInterface
{
    public function setProxy($proxy);
    public function getProxy();
    public function setRequest($request);
    public function getRequest();
    public function setResponse($response);
    public function getResponse();
    public function connect();
    public function send($method, $url, $body);
    public function read();
    public function close();
}