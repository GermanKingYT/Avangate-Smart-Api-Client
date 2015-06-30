<?php
namespace AvangateSmartApiClient\Order;

use AvangateSmartApiClient\Module\AbstractSubject;

class PaymentMethodCCNOPCIHandler extends AbstractSubject
{
    private $paymentMethodObj;

    public function __construct(Obj\PaymentMethodCCNOPCI $paymentMethodObj)
    {
        $this->paymentMethodObj = $paymentMethodObj;
    }

    public function getOriginalInstance()
    {
        return $this->paymentMethodObj;
    }

    /**
     * Return the recurring flag.
     * @return string
     */
    public function getRecurringEnabled()
    {
        return $this->getOriginalInstance()->RecurringEnabled;
    }

    /**
     * Set the recurring flag.
     * @param string $RecurringEnabled
     */
    public function setRecurringEnabled($RecurringEnabled)
    {
        $this->getOriginalInstance()->RecurringEnabled = $RecurringEnabled;
        $this->notify(); // update observers
    }

    /**
     * @return string
     */
    public function getReturnURL(){
        return $this->getOriginalInstance()->ReturnURL;
    }

    /**
     * @param $ReturnURL
     */
    public function setReturnURL($ReturnURL)
    {
        $this->getOriginalInstance()->ReturnURL = $ReturnURL;
        $this->notify(); // update observers
    }

    /**
     * @return string
     */
    public function getRedirectURL(){
        return $this->getOriginalInstance()->RedirectURL;
    }

    /**
     * @param $RedirectURL
     */
    public function setRedirectURL($RedirectURL)
    {
        $this->getOriginalInstance()->RedirectURL = $RedirectURL;
        $this->notify(); // update observers
    }
}