<?php
namespace AvangateSmartApiClient\Order;

use AvangateSmartApiClient\Module\ObserverInterface;
use AvangateSmartApiClient\Module\AbstractSubject;
use AvangateSmartApiClient\Order\Exception\RuntimeException;
use AvangateSmartApiClient\Order\Obj\PaymentMethod;

class PaymentDetailsHandler extends AbstractSubject implements ObserverInterface
{
    protected $paymentDetailsObj;

    public function __construct(Obj\PaymentDetails $paymentDetailsObj)
    {
        $this->paymentDetailsObj = $paymentDetailsObj;
    }

    public function getOriginalInstance()
    {
        return $this->paymentDetailsObj;
    }

    /**
     * @param $Type
     */
    public function setType($Type)
    {
        // Safety checks.
        if (gettype($Type) != "string" || empty($Type)) {
            throw new Exception\InvalidArgumentException(
                'Payment type must be a string'
            );
        }
        $Type = strtoupper($Type);
        $this->getOriginalInstance()->Type = $Type;
        $this->clearPaymentMethodIfSwitchingType();
        $this->notify(); // update observers
    }

    /**
     * Return the Payment Type, if set.
     */
    public function getType()
    {
        return $this->getOriginalInstance()->Type;
    }

    /**
     * When switching types, make sure that the PaymentMethod obj is cleared (if needed),
     * to ensure that when building the PaymentMethod handler there won't be any issues with the Handler's constructor.
     * Throws exception if invalid PaymentMethod (non-object).
     * @todo: I think we should clear it all the time! (Serban)
     */
    private function clearPaymentMethodIfSwitchingType()
    {
        if (!($this->getOriginalInstance()->PaymentMethod instanceof PaymentMethod)) {
            throw new Exception\RuntimeException(
                'Payment method must be an instance of PaymentMethod.'
            );
        }

        $newType   = strtoupper($this->getOriginalInstance()->Type);

        if (
            ( $newType == "PAYPAL" && !($this->getOriginalInstance()->PaymentMethod instanceof Obj\PaymentMethodPaypal) ) ||
            ( ($newType == "CC" || $newType == "TEST") && !($this->getOriginalInstance()->PaymentMethod instanceof Obj\PaymentMethodCC) ) ||
            ( $newType == 'CCNOPCI' && !($this->getOriginalInstance()->PaymentMethod instanceof Obj\PaymentMethodCCNOPCI) )
        ) {
            $this->getOriginalInstance()->PaymentMethod = null;
        }
    }

    public function setCurrency($Currency)
    {
        if (gettype($Currency) != "string" || empty($Currency)) {
            throw new Exception\InvalidArgumentException('The input payment type should not be empty or non-string.');
        }

        $this->getOriginalInstance()->Currency = strtoupper($Currency);
        $this->notify(); // update observers
    }

    /**
     * Return the Payment Currency, if set.
     * If not set or null, then return null.
     *
     * @return null|string
     */
    public function getCurrency()
    {
        if (!isset($this->getOriginalInstance()->Currency) || is_null($this->getOriginalInstance()->Currency)) {
            return null;
        }

        return strtoupper($this->getOriginalInstance()->Currency);
    }

    /**
     * Will set the CustomerIP. Will not change CustomerIP when input is not string.
     * Returns true if value was set and false when the value was not set.
     *
     * @param   string $CustomerIP
     * @return  bool success
     */
    public function setCustomerIP($CustomerIP)
    {
        $this->getOriginalInstance()->CustomerIP = $CustomerIP;
        $this->notify(); // update observers
        return true;
    }

    /**
     * Return the CustomerIP value.
     * @return null|string
     */
    public function getCustomerIP()
    {
        return $this->getOriginalInstance()->CustomerIP;
    }

    /**
     * Return the PaymentMethod Handler matched for the Payment Type (if set).
     * If Payment Type is not set, then return false.
     */
    public function getPaymentMethod()
    {
        $paymentType = $this->getType();

        if (empty($paymentType)) {
           throw new Exception\RuntimeException(
               'Payment method type must be set prior to getting the payment method handler methods.'
           );
        }

        $paymentType = strtoupper($paymentType);

        switch ($paymentType) {
            case 'CC':
            case 'TEST':
                $PaymentMethodHandler = new PaymentMethodCCHandler($this->getOriginalInstance()->PaymentMethod);
                $PaymentMethodHandler->attach($this);
                return $PaymentMethodHandler;
                break;

            case 'CCNOPCI':
                $PaymentMethodHandler = new PaymentMethodCCNOPCIHandler($this->getOriginalInstance()->PaymentMethod);
                $PaymentMethodHandler->attach($this);
                return $PaymentMethodHandler;
                break;

            case 'PAYPAL':
                $PaymentMethodHandler = new PaymentMethodPaypalHandler($this->getOriginalInstance()->PaymentMethod);
                $PaymentMethodHandler->attach($this);
                return $PaymentMethodHandler;
                break;

            default:
                throw new Exception\RuntimeException(
                    'Unsupported payment method supplied.'
                );
                break;
        }
    }

    /**
     * Observer update method.
     * @param AbstractSubject $PaymentMethodHandler
     * @return bool
     */
    public function update(AbstractSubject $PaymentMethodHandler)
    {
        $this->getOriginalInstance()->PaymentMethod = $PaymentMethodHandler->getOriginalInstance();
        $this->notify(); // update observers
        return true;
    }
}
