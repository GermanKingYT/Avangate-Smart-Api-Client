<?php
namespace AvangateSmartApiClient\Order\Obj;

class PaymentDetails
{
	public $Currency;
	public $Type;
	public $CustomerIP;
	
	/**
	 * @var PaymentMethodCC|PaymentMethodCCNOPCI|PaymentMethodPaypal
	 */
	public $PaymentMethod;

}