<?php
namespace AvangateSmartApiClient\Order;

class DeliveryDetailsHandler
{
    protected $deliveryDetailsObj;

    public function __construct(Obj\DeliveryDetails $deliveryDetailsObj)
    {
        $this->deliveryDetailsObj = $deliveryDetailsObj;
    }

    public function getOriginalInstance()
    {
        return $this->deliveryDetailsObj;
    }
}
