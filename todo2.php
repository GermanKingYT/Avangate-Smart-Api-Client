<?php
	OrderItemModel
	
    /**
     * Helper method for getting the corresponding ProductModel,
     * based on the CartItem's ProductCode.
     * @return Product\ProductFacade
     */
    public function getProduct()
    {
        if (!isset($this->product)) {
            $this->product = $this->apiObjectsModelHandler->getProductByCode($this->getCode());
        }
        return $this->product;
    }
	
	
	PaymentDetailsHandler
	
	$supportedPaymentMethods = \Acart\Handler\ApiHandler::getPaymentMethods();
	if (!in_array($Type, $supportedPaymentMethods)) {
		throw new \Acart\Exception("The input payment type is not supported.", "INVALID_PAYMENT_TYPE");
	}	