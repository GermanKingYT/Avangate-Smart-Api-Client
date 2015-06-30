<?php
namespace AvangateSmartApiClient\Order;

use AvangateSmartApiClient\Module\AbstractSubject;

class PaymentMethodCCHandler extends AbstractSubject
{
    private $paymentMethodObj;

    /**
     * Will store the input instanceFromApi object.
     * If not passed, a blank Obj\PaymentMethodCC will be generated and stored.
     */
    /**
     * @param Obj\PaymentMethodCC $paymentMethodObj
     */
    public function __construct(Obj\PaymentMethodCC $paymentMethodObj)
    {
        $this->paymentMethodObj = $paymentMethodObj;
    }

    /**
     * Will return the instance object.
     * @return Obj\PaymentMethodCC
     */
    public function getOriginalInstance()
    {
        return $this->paymentMethodObj;
    }

    /**
     * Return the CardNumber
     * @return string
     */
    public function getCardNumber()
    {
        return $this->getOriginalInstance()->CardNumber;
    }

    /**
     * Set the CardNumber.
     * @param string $CardNumber
     */
    public function setCardNumber($CardNumber)
    {
        $this->getOriginalInstance()->CardNumber = $CardNumber;
        $this->notify(); // update observers
    }

    /**
     * Return the CardNumber
     * @return string
     */
    public function getCardType()
    {
        return $this->getOriginalInstance()->CardType;
    }

    /**
     * Set the CardNumber.
     * @param string $CardType
     */
    public function setCardType($CardType)
    {
        $this->getOriginalInstance()->CardType = $CardType;
        $this->notify(); // update observers
    }

    /**
     * Return the CardNumber
     * @return string
     */
    public function getExpirationYear()
    {
        return $this->getOriginalInstance()->ExpirationYear;
    }

    /**
     * Set the CardNumber.
     * @param string $ExpirationYear
     */
    public function setExpirationYear($ExpirationYear)
    {
        $this->getOriginalInstance()->ExpirationYear = $ExpirationYear;
        $this->notify(); // update observers
    }

    /**
     * Return the CardNumber
     * @return string
     */
    public function getExpirationMonth()
    {
        return $this->getOriginalInstance()->ExpirationMonth;
    }

    /**
     * Set the CardNumber.
     * @param string $ExpirationMonth
     */
    public function setExpirationMonth($ExpirationMonth)
    {
        $this->getOriginalInstance()->ExpirationMonth = $ExpirationMonth;
        $this->notify(); // update observers
    }

    /**
     * Return the CardNumber
     * @return string
     */
    public function getCCID()
    {
        return $this->getOriginalInstance()->CCID;
    }

    /**
     * Set the CardNumber.
     * @param string $CCID
     */
    public function setCCID($CCID)
    {
        $this->getOriginalInstance()->CCID = $CCID;
        $this->notify(); // update observers
    }

    /**
     * Return the CardNumber
     * @return string
     */
    public function getHolderName()
    {
        return $this->getOriginalInstance()->HolderName;
    }

    /**
     * Set the CardNumber.
     * @param string $HolderName
     */
    public function setHolderName($HolderName)
    {
        $this->getOriginalInstance()->HolderName = $HolderName;
        $this->notify(); // update observers
    }

    /**
     * Time that the user spent on filling the 'Holder name' field.
     * @param integer $HolderNameTime
     */
    public function setHolderNameTime($HolderNameTime)
    {
        $this->getOriginalInstance()->HolderNameTime = $HolderNameTime;
        $this->notify(); // update observers
    }

    /**
     * Time that the user spent on filling the 'Credit card' field.
     * @param integer $CardNumberTime
     */
    public function setCardNumberTime($CardNumberTime)
    {
        $this->getOriginalInstance()->CardNumberTime = $CardNumberTime;
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
     * Return the FirstDigits of the CardNumber
     * @return string|null
     */
    public function getFirstDigits()
    {
        return $this->getOriginalInstance()->FirstDigits;
    }

    /**
     * Return the FirstDigits of the CardNumber
     * @return string|null
     */
    public function getLastDigits()
    {
        return $this->getOriginalInstance()->LastDigits;
    }

    /**
     * @param $FirstDigits
     */
    public function setFirstDigits($FirstDigits)
    {
        $this->getOriginalInstance()->FirstDigits = $FirstDigits;
        $this->notify(); // update observers
    }

    /**
     * @param $LastDigits
     */
    public function setLastDigits($LastDigits)
    {
        $this->getOriginalInstance()->LastDigits = $LastDigits;
        $this->notify(); // update observers
    }
}
