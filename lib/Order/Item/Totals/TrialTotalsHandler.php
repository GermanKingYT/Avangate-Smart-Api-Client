<?php
namespace AvangateSmartApiClient\Order\Item\Totals;

use AvangateSmartApiClient\Module\AbstractSubject;

class TrialTotalsHandler extends AbstractSubject
{
    private $trialTotalsObj;

    public function __construct(Obj\TrialTotalsObj $trialTotalsObj)
    {
        $this->trialTotalsObj = $trialTotalsObj;
    }

    public function getOriginalInstance()
    {
        return $this->trialTotalsObj;
    }

    public function setPeriod($Period)
    {
        if (!is_numeric($Period)) {
            return false;
        }

        $Period = (int)$Period;

        $this->getOriginalInstance()->Period = $Period;
        $this->notify();

        return true;
    }

    public function getPeriod()
    {
        return $this->getOriginalInstance()->Period;
    }

    public function setPrice($Price)
    {
        if (!is_numeric($Price)) {
            return false;
        }

        $this->getOriginalInstance()->Price = $Price;
        $this->notify();

        return true;
    }

    public function getPrice()
    {
        return $this->getOriginalInstance()->Price;
    }

    public function setGrossPrice($GrossPrice)
    {
        $this->getOriginalInstance()->GrossPrice = $GrossPrice;
        $this->notify();
    }

    public function getGrossPrice()
    {
        return $this->getOriginalInstance()->GrossPrice;
    }

    public function setNetPrice($NetPrice)
    {
        $this->getOriginalInstance()->NetPrice = $NetPrice;
        $this->notify();
    }

    public function getNetPrice()
    {
        return $this->getOriginalInstance()->NetPrice;
    }

    public function setVAT($VAT)
    {
        $this->getOriginalInstance()->VAT = $VAT;
        $this->notify();
    }

    public function getVAT()
    {
        return $this->getOriginalInstance()->VAT;
    }

}
