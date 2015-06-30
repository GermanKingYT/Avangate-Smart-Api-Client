<?php
$order = '{
  "CartId": 1421244650,
  "Currency": "USD",
  "Language": "EN",
  "Country": "US",
  "CustomerIP": "127.0.0.1",
  "LocalTime": "2015-01-14 09:00:00",
  "Source": "ghita.org",
  "AffiliateSource": null,
  "Items": [
    {
      "AvangateId": 4586167,
      "Code": "3001",
      "Quantity": "5",
      "PriceOptions": [],
      "Price": {
        "NetPrice": 179.55,
        "GrossPrice": 190.32,
        "VAT": 10.77,
        "Discount": 0,
        "UnitPrice": null,
        "UnitVAT": 1.2,
        "UnitNetPrice": 19.95,
        "UnitGrossPrice": 21.15,
        "UnitAffiliateCommission": 0,
        "UnitDiscount": 0,
        "UnitNetDiscountedPrice": 19.95,
        "UnitGrossDiscountedPrice": 21.15,
        "NetDiscountedPrice": 179.55,
        "GrossDiscountedPrice": 190.32
      },
      "CrossSell": null,
      "Trial": null,
      "AdditionalFields": null,
      "Promotion": false,
      "AdditionalInfo": null
    }
  ],
  "Promotions": [],
  "ExternalReference": "",
  "CustomerReference": "",
  "BillingDetails": {
    "FiscalCode": "",
    "Company": "",
    "FirstName": "Serban",
    "LastName": "Test",
    "Address": "str. Londra nr. 7",
    "City": "Bucuresti",
    "PostalCode": "011761",
    "Country": "US",
    "State": "WV",
    "Email": "sg@avangate.com"
  },
  "DeliveryDetails": null,
  "PaymentDetails": {
    "Currency": "USD",
    "Type": "CC",
    "CustomerIP": "192.0.0.3",
    "PaymentMethod": {
      "CardNumber": null,
      "CardType": null,
      "ExpirationYear": null,
      "ExpirationMonth": null,
      "CCID": null,
      "HolderName": null,
      "RecurringEnabled": null,
      "HolderNameTime": null,
      "CardNumberTime": null,
      "FirstDigits": 4111,
      "LastDigits": 1111
    }
  },
  "Origin": null,
  "Shipping": 0,
  "ShippingVAT": null,
  "NetPrice": 179.55,
  "GrossPrice": 190.32,
  "VAT": 10.77,
  "AffiliateCommission": null,
  "AvangateCommission": null,
  "Discount": 0,
  "NetDiscountedPrice": 179.55,
  "GrossDiscountedPrice": 190.32,
  "AdditionalFields": null,
  "RefNo": 11316734,
  "OrderNo": 0,
  "ShopperRefNo": null,
  "Status": "AUTHRECEIVED",
  "ApproveStatus": "WAITING",
  "OrderDate": "2015-01-14 16:18:46",
  "FinishDate": null,
  "HasShipping": false,
  "CustomerDetails": null,
  "Errors": {
    "PAYMENT_ERROR": "The supplied credit card [] is not supported."
  }
}';
//$order = preg_replace('/\s+/i', '', $order);
return json_decode($order);