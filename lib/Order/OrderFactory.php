<?php
namespace AvangateSmartApiClient\Order;

use AvangateSmartApiClient\Order\Obj\DeliveryDetails;

class OrderFactory {

    public static function __callStatic($name, $arguments)
    {
        if (!method_exists(__CLASS__, $name)) {
            throw new \BadMethodCallException(
                sprintf('Method [%s] does not exist.', $name)
            );
        }

        return call_user_func_array(array(__CLASS__, $name), $arguments);
    }

    public function createOrderItemObj()
    {
        return new Item\Obj\OrderItem;
    }

    public function createOrderItemHandler(Item\Obj\OrderItem $orderItemObj)
    {
        return new Item\OrderItemHandler($orderItemObj);
    }

    public function createOrderItemTotalsObj()
    {
        return new Item\Totals\Obj\TotalsObj();
    }

    public function createOrderItemTrialTotalsObj()
    {
        return new Item\Totals\Obj\TrialTotalsObj();
    }

    public function createOrderObj()
    {
        return new Obj\Order();
    }

    public function createOrderTotalsObj()
    {
        return new Totals\Obj\Order();
    }

    public function createOrderTotalsHandler(Totals\Obj\Order $orderTotalsObj)
    {
        return new Totals\TotalsHandler($orderTotalsObj);
    }

    public function createOrderHandler(Obj\Order $orderApiObj)
    {
        return new OrderHandler($orderApiObj);
    }

    /**
     * @param OrderHandler $orderHandler
     * @return OrderModel
     */
    public function createOrderModel(OrderHandler $orderHandler)
    {
        return new OrderModel($orderHandler);
    }

    /**
     * @return Obj\CustomerDetails
     */
    public function createCustomerDetailsObj()
    {
        return new Obj\CustomerDetails();
    }

    /**
     * @param Obj\CustomerDetails $customerDetailsObj
     * @return CustomerDetailsHandler
     */
    public function createCustomerDetailsHandler(Obj\CustomerDetails $customerDetailsObj)
    {
        return new CustomerDetailsHandler($customerDetailsObj);
    }

    /**
     * @param $paymentMethodCode
     * @return Obj\PaymentMethodCC|Obj\PaymentMethodCCNOPCI|Obj\PaymentMethodPaypal
     */
    public function createPaymentMethodObj($paymentMethodCode)
    {
        $className = sprintf(__NAMESPACE__ . '\\Obj\\PaymentMethod%s', $paymentMethodCode);
        if (!class_exists($className)) {
            throw new Exception\InvalidArgumentException(
                sprintf('Invalid class name. [%s]', $className),
                0
            );
        }

        return new $className;
    }

    /**
     * @return Obj\BillingDetails
     */
    public function createBillingDetailsObj()
    {
        return new Obj\BillingDetails;
    }

    /**
     * @param Obj\BillingDetails $billingDetailsObj
     * @return BillingDetailsHandler
     */
    public function createBillingDetailsHandler(Obj\BillingDetails $billingDetailsObj)
    {
        return new BillingDetailsHandler($billingDetailsObj);
    }

    /**
     * @return Obj\DeliveryDetails
     */
    public function createDeliveryDetailsObj()
    {
        return new Obj\DeliveryDetails();
    }

    /**
     * @param DeliveryDetails $deliveryDetails
     * @return DeliveryDetailsHandler
     */
    public function createDeliveryDetailsHandler(Obj\DeliveryDetails $deliveryDetails)
    {
        return new DeliveryDetailsHandler($deliveryDetails);
    }

    /**
     * @return Obj\PaymentDetails
     */
    public function createPaymentDetailsObj()
    {
        return new Obj\PaymentDetails;
    }

    /**
     * @param Obj\PaymentDetails $paymentDetailsObj
     * @return PaymentDetailsHandler
     */
    public function createPaymentDetailsHandler(Obj\PaymentDetails $paymentDetailsObj)
    {
        return new PaymentDetailsHandler($paymentDetailsObj);
    }

}