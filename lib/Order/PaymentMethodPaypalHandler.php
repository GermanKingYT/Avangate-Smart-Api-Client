<?php
namespace AvangateSmartApiClient\Order;

use AvangateSmartApiClient\Module\AbstractSubject;

class PaymentMethodPaypalHandler extends AbstractSubject
{
    private $paymentMethodObj;

    public function __construct(Obj\PaymentMethodPaypal $paymentMethodObj)
    {
        $this->paymentMethodObj = $paymentMethodObj;
    }

    public function getOriginalInstance()
    {
        return $this->paymentMethodObj;
    }

    /**
     * Set the Email.
     * @param string $Email
     */
    public function setEmail($Email)
    {
        $this->getOriginalInstance()->Email = $Email;
        $this->notify();
    }

    /**
     * Return the Email.
     * @return string
     */
    public function getEmail()
    {
        return $this->getOriginalInstance()->Email;
    }

    /**
     * @param $ReturnURL
     */
    public function setReturnURL($ReturnURL)
    {
        $this->getOriginalInstance()->ReturnURL = $ReturnURL;
        $this->notify();
    }

    /**
     * @return string
     */
    public function getReturnURL()
    {
        return $this->getOriginalInstance()->ReturnURL;
    }

    /**
     * @param $CancelURL
     */
    public function setCancelURL($CancelURL)
    {
        $this->getOriginalInstance()->CancelURL = $CancelURL;
        $this->notify();
    }

    /**
     * @return string
     */
    public function getCancelURL()
    {
        return $this->getOriginalInstance()->CancelURL;
    }

    /**
     * @param $RedirectURL
     */
    public function setRedirectURL($RedirectURL)
    {
        $this->getOriginalInstance()->RedirectURL = $RedirectURL;
    }

    /**
     * @return string
     */
    public function getRedirectURL(){
        return $this->getOriginalInstance()->RedirectURL;
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
     * Return the recurring flag.
     * @return string
     */
    public function getRecurringEnabled()
    {
        return $this->getOriginalInstance()->RecurringEnabled;
    }
}
