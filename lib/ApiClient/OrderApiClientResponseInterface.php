<?php
namespace AvangateSmartApiClient\ApiClient;

use AvangateSmartApiClient\Order;

interface OrderApiClientResponseInterface
{
    public function getPaymentMethods();
    public function getPaymentMethodCurrencies($paymentMethodCode);
    public function getPaymentMethodCountries($paymentMethodCode);
    public function getPrice(\stdClass $cartItem, \stdClass $BillingDetails, $CurrencyCode, $CouponCode);
    public function getContents(Order\Obj\Order $cartApiObj);
    public function placeOrder(Order\Obj\Order $cartApiObj);
}