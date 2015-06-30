<?php
namespace AvangateSmartApiClient\Order\Obj;

class PaymentMethodCC extends PaymentMethod
{
    public $CardNumber;
    public $CardType;
    public $ExpirationYear;
    public $ExpirationMonth;
    public $CCID;
    public $HolderName;
    public $RecurringEnabled;

    public $HolderNameTime;
    public $CardNumberTime;

    public $FirstDigits;
    public $LastDigits;
}
