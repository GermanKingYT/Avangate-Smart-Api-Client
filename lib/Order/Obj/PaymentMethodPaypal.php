<?php
namespace AvangateSmartApiClient\Order\Obj;

class PaymentMethodPaypal extends PaymentMethod
{
    public $Email;
    public $ReturnURL;    
    public $CancelURL; 

    public $RecurringEnabled;

    // Finish specific fields.
    public $RedirectURL;
}
