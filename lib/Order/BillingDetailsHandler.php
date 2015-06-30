<?php
namespace AvangateSmartApiClient\Order;

class BillingDetailsHandler
{
    protected $billingDetailsObj;

    public function __construct(Obj\BillingDetails $billingDetailsObj)
    {
        $this->billingDetailsObj = $billingDetailsObj;
    }

    public function getOriginalInstance()
    {
        return $this->billingDetailsObj;
    }

    public function setFiscalCode($FiscalCode)
    {
        $this->getOriginalInstance()->FiscalCode = $FiscalCode;
    }

    public function getFiscalCode()
    {
        return $this->getOriginalInstance()->FiscalCode;
    }

    public function setCompany($Company)
    {
        $this->getOriginalInstance()->Company = $Company;
    }

    public function getCompany()
    {
        return $this->getOriginalInstance()->Company;
    }

    public function setFirstName($FirstName)
    {
        $this->getOriginalInstance()->FirstName = $FirstName;
    }

    public function getFirstName()
    {
        return $this->getOriginalInstance()->FirstName;
    }

    public function setLastName($LastName)
    {
        $this->getOriginalInstance()->LastName = $LastName;
    }

    public function getLastName()
    {
        return $this->getOriginalInstance()->LastName;
    }

    public function setAddress($Address)
    {
        $this->getOriginalInstance()->Address = $Address;
    }

    public function getAddress()
    {
        return $this->getOriginalInstance()->Address;
    }

    public function setCity($City)
    {
        $this->getOriginalInstance()->City = $City;
    }

    public function getCity()
    {
        return $this->getOriginalInstance()->City;
    }

    public function setPostalCode($PostalCode)
    {
        $this->getOriginalInstance()->PostalCode = $PostalCode;
    }

    public function getPostalCode()
    {
        return $this->getOriginalInstance()->PostalCode;
    }

    public function setCountry($Country)
    {
        $this->getOriginalInstance()->Country = $Country;
    }

    public function getCountry()
    {
        return $this->getOriginalInstance()->Country;
    }

    public function setState($State)
    {
        $this->getOriginalInstance()->State = $State;
    }

    public function getState()
    {
        return $this->getOriginalInstance()->State;
    }

    public function setEmail($Email)
    {
        $this->getOriginalInstance()->Email = $Email;
    }

    public function getEmail()
    {
        return $this->getOriginalInstance()->Email;
    }
}