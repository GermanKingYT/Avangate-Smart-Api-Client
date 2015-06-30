<?php
namespace AvangateSmartApiClient\Order;

use AvangateSmartApiClient\Module\AbstractSubject;

class CustomerDetailsHandler extends AbstractSubject
{
    private $customerDetailsObj;

    public function __construct(Obj\CustomerDetails $customerDetailsObj)
    {
        $this->customerDetailsObj = $customerDetailsObj;
    }

    public function getOriginalInstance()
    {
        return $this->customerDetailsObj;
    }

    /**
     * @param string $AvangateCustomerReference
     */
    public function setAvangateCustomerReference($AvangateCustomerReference)
    {
        $this->getOriginalInstance()->AvangateCustomerReference = $AvangateCustomerReference;
        $this->notify(); // update observers
    }

    /**
     * @return string
     */
    public function getAvangateCustomerReference()
    {
        return $this->getOriginalInstance()->AvangateCustomerReference;
    }

    /**
     * @param string $ExternalCustomerReference
     */
    public function setExternalCustomerReference($ExternalCustomerReference)
    {
        $this->getOriginalInstance()->ExternalCustomerReference = $ExternalCustomerReference;
        $this->notify(); // update observers
    }

    /**
     * @return string
     */
    public function getExternalCustomerReference()
    {
        return $this->getOriginalInstance()->ExternalCustomerReference;
    }

    /**
     * @param string $FirstName
     */
    public function setFirstName($FirstName)
    {
        $this->getOriginalInstance()->FirstName = $FirstName;
        $this->notify(); // update observers
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->getOriginalInstance()->FirstName;
    }

    /**
     * @param string $LastName
     */
    public function setLastName($LastName)
    {
        $this->getOriginalInstance()->LastName = $LastName;
        $this->notify(); // update observers
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->getOriginalInstance()->LastName;
    }

    /**
     * @param string $CompanyName
     */
    public function setCompanyName($CompanyName)
    {
        $this->getOriginalInstance()->CompanyName = $CompanyName;
        $this->notify(); // update observers
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->getOriginalInstance()->CompanyName;
    }

    /**
     * @param string $FiscalCode
     */
    public function setFiscalCode($FiscalCode)
    {
        $this->getOriginalInstance()->FiscalCode = $FiscalCode;
        $this->notify(); // update observers
    }

    /**
     * @return string
     */
    public function getFiscalCode()
    {
        return $this->getOriginalInstance()->FiscalCode;
    }

    /**
     * @param string $Address
     */
    public function setAddress($Address)
    {
        $this->getOriginalInstance()->Address = $Address;
        $this->notify(); // update observers
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->getOriginalInstance()->Address;
    }

    /**
     * @param string $City
     */
    public function setCity($City)
    {
        $this->getOriginalInstance()->City = $City;
        $this->notify(); // update observers
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->getOriginalInstance()->City;
    }

    /**
     * @param string $State
     */
    public function setState($State)
    {
        $this->getOriginalInstance()->State = $State;
        $this->notify(); // update observers
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->getOriginalInstance()->State;
    }

    /**
     * @param string $PostalCode
     */
    public function setPostalCode($PostalCode)
    {
        $this->getOriginalInstance()->PostalCode = $PostalCode;
        $this->notify(); // update observers
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->getOriginalInstance()->PostalCode;
    }

    /**
     * @param $Country
     */
    public function setCountry($Country)
    {
        $Country = strtoupper($Country);
        $this->getOriginalInstance()->Country = $Country;
        $this->notify(); // update observers
    }

    /**
     * @return null|string
     */
    public function getCountry()
    {
        return isset($this->getOriginalInstance()->Country) ? strtoupper($this->getOriginalInstance()->Country) : null;
    }

    /**
     * @param string $Phone
     */
    public function setPhone($Phone)
    {
        $this->getOriginalInstance()->Phone = $Phone;
        $this->notify(); // update observers
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->getOriginalInstance()->Phone;
    }

    /**
     * @param string $Fax
     */
    public function setFax($Fax)
    {
        $this->getOriginalInstance()->Fax = $Fax;
        $this->notify(); // update observers
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->getOriginalInstance()->Fax;
    }

    /**
     * @param string $Email
     */
    public function setEmail($Email)
    {
        $this->getOriginalInstance()->Email = $Email;
        $this->notify(); // update observers
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->getOriginalInstance()->Email;
    }

    /**
     * @param int $Enabled
     */
    public function setEnabled($Enabled)
    {
        $this->getOriginalInstance()->Enabled = $Enabled;
        $this->notify(); // update observers
    }

    /**
     * @return int
     */
    public function getEnabled()
    {
        return $this->getOriginalInstance()->Enabled;
    }

    /**
     * @param string $Trial
     */
    public function setTrial($Trial)
    {
        $this->getOriginalInstance()->Trial = $Trial;
        $this->notify(); // update observers
    }

    /**
     * @return string
     */
    public function getTrial()
    {
        return $this->getOriginalInstance()->Trial;
    }

    /**
     * Checks if the instance is empty.
     * @return boolean
     */
    public function isEmpty()
    {
        foreach ($this->getOriginalInstance() as $key => $value) {
            if (!is_null($value)) {
                return false;
            }
        }

        return true;
    }
}