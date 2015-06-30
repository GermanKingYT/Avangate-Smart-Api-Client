<?php
$response = '{
  "AvangateId": 4586155,
  "ProductCode": "6000",
  "ProductType": "REGULAR",
  "ProductName": "FICO\u00ae 3 Bureau Monitoring",
  "ProductVersion": "",
  "GroupName": "General",
  "ShippingClass": null,
  "GiftOption": false,
  "ShortDescription": "<p>\r\n\tYour FICO Scores and credit reports from Equifax, TransUnion and Experian; plus, daily monitoring with alerts of your one-bureau FICO Score and three-bureau credit reports.</p>",
  "LongDescription": "",
  "SystemRequirements": "",
  "ProductCategory": false,
  "Platforms": [],
  "ProductImages": [],
  "TrialUrl": "",
  "TrialDescription": "",
  "Enabled": true,
  "AdditionalFields": [],
  "Translations": {
    "ES": {
      "LongDescription": null,
      "TrialUrl": null,
      "TrialDescription": null,
      "SystemRequirements": null,
      "Name": null,
      "Description": "Sus puntajes FICO Score e informes de cr\u00e9dito de Equifax, TransUnion y Experian m\u00e1s controles diarios con alertas de su puntaje FICO Score de un bur\u00f3 e informes de cr\u00e9dito de tres bur\u00f3s.",
      "Language": "ES"
    }
  },
  "PricingConfigurations": [
    {
      "Name": "Without base price",
      "Default": true,
      "BillingCountries": [],
      "PricingSchema": "FLAT",
      "PriceType": "NET",
      "DefaultCurrency": "USD",
      "Prices": {
        "Regular": [
          {
            "Amount": 219,
            "Currency": "USD",
            "MinQuantity": 1,
            "MaxQuantity": 1,
            "OptionCodes": []
          }
        ],
        "Renewal": []
      },
      "PriceOptions": []
    }
  ],
  "Prices": [],
  "BundleProducts": [],
  "Fulfillment": "NO_DELIVERY",
  "GeneratesSubscription": true,
  "SubscriptionInformation": {
    "DeprecatedProducts": [],
    "BillingCycle": 12,
    "BillingCycleUnits": "M",
    "IsOneTimeFee": false,
    "ContractPeriod": {
      "Period": -1,
      "PeriodUnits": null,
      "IsUnlimited": true,
      "Action": "RESTART"
    },
    "GracePeriod": {
      "Type": "GLOBAL",
      "Period": 0,
      "PeriodUnits": "D",
      "IsUnlimited": false
    }
  }
}';
return json_decode($response);