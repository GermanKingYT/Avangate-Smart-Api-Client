<?php
$response = <<<JSON
{
  "AvangateId": 4547120,
  "ProductCode": "PNF1",
  "ProductType": "REGULAR",
  "ProductName": "Product Name One",
  "ProductVersion": 1,
  "GroupName": "Product Name Group",
  "ShippingClass": null,
  "GiftOption": false,
  "ShortDescription": "<p>\r\n\tLorem ipsum1</p>",
  "LongDescription": "<p>\r\n\tLorem ipsum2</p>",
  "SystemRequirements": "<p>\r\n\tLorem ipsum3</p>",
  "ProductCategory": false,
  "Platforms": [],
  "ProductImages": [
    {
      "Default": true,
      "URL": "http://sandbox19.avangate.local/images/merchant/1fd09c5f59a8ff35d499c0ee25a1d47e/products/dvdfab_bluray2mobile_s.png"
    }
  ],
  "TrialUrl": "",
  "TrialDescription": "",
  "Enabled": true,
  "AdditionalFields": [],
  "Translations": {
    "EN": {
      "LongDescription": null,
      "TrialUrl": null,
      "TrialDescription": "",
      "SystemRequirements": "<p>\r\n\tLorem ipsum3</p>",
      "Name": null,
      "Description": null,
      "Language": "EN"
    },
    "FR": {
      "LongDescription": null,
      "TrialUrl": null,
      "TrialDescription": null,
      "SystemRequirements": null,
      "Name": null,
      "Description": "<p>\r\n\tLorem ipsum1 fr</p>\r\n",
      "Language": "FR"
    }
  },
  "PricingConfigurations": [
    {
      "Name": "Product Name First's Price Configuration",
      "Default": true,
      "BillingCountries": [],
      "PricingSchema": "DYNAMIC",
      "PriceType": "NET",
      "DefaultCurrency": "USD",
      "Prices": {
        "Regular": [
          {
            "Amount": 40,
            "Currency": "USD",
            "MinQuantity": 1,
            "MaxQuantity": 3,
            "OptionCodes": []
          },
          {
            "Amount": 10,
            "Currency": "EUR",
            "MinQuantity": 1,
            "MaxQuantity": 3,
            "OptionCodes": []
          },
          {
            "Amount": 33,
            "Currency": "GBP",
            "MinQuantity": 1,
            "MaxQuantity": 3,
            "OptionCodes": []
          },
          {
            "Amount": 234234,
            "Currency": "JPY",
            "MinQuantity": 1,
            "MaxQuantity": 3,
            "OptionCodes": []
          },
          {
            "Amount": 333,
            "Currency": "USD",
            "MinQuantity": 4,
            "MaxQuantity": 99999,
            "OptionCodes": []
          },
          {
            "Amount": 33,
            "Currency": "EUR",
            "MinQuantity": 4,
            "MaxQuantity": 99999,
            "OptionCodes": []
          }
        ],
        "Renewal": []
      },
      "PriceOptions": [
        {
          "Code": "PERKS",
          "Required": false
        }
      ]
    },
    {
      "Name": "Second Pricing Configuration",
      "Default": false,
      "BillingCountries": [],
      "PricingSchema": "FLAT",
      "PriceType": "NET",
      "DefaultCurrency": "EUR",
      "Prices": {
        "Regular": [
          {
            "Amount": 1,
            "Currency": "EUR",
            "MinQuantity": 1,
            "MaxQuantity": 5,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "pistol",
                  "bomb",
                  "armor"
                ]
              }
            ]
          },
          {
            "Amount": 2,
            "Currency": "EUR",
            "MinQuantity": 1,
            "MaxQuantity": 5,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "pistol",
                  "bomb"
                ]
              }
            ]
          },
          {
            "Amount": 3,
            "Currency": "EUR",
            "MinQuantity": 1,
            "MaxQuantity": 5,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "pistol",
                  "armor"
                ]
              }
            ]
          },
          {
            "Amount": 4,
            "Currency": "EUR",
            "MinQuantity": 1,
            "MaxQuantity": 5,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "pistol"
                ]
              }
            ]
          },
          {
            "Amount": 5,
            "Currency": "EUR",
            "MinQuantity": 1,
            "MaxQuantity": 5,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "bomb",
                  "armor"
                ]
              }
            ]
          },
          {
            "Amount": 6,
            "Currency": "EUR",
            "MinQuantity": 1,
            "MaxQuantity": 5,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "bomb"
                ]
              }
            ]
          },
          {
            "Amount": 7,
            "Currency": "EUR",
            "MinQuantity": 1,
            "MaxQuantity": 5,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "armor"
                ]
              }
            ]
          },
          {
            "Amount": 8,
            "Currency": "EUR",
            "MinQuantity": 1,
            "MaxQuantity": 5,
            "OptionCodes": []
          },
          {
            "Amount": 9,
            "Currency": "EUR",
            "MinQuantity": 6,
            "MaxQuantity": 99999,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "pistol",
                  "bomb",
                  "armor"
                ]
              }
            ]
          },
          {
            "Amount": 10,
            "Currency": "EUR",
            "MinQuantity": 6,
            "MaxQuantity": 99999,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "pistol",
                  "bomb"
                ]
              }
            ]
          },
          {
            "Amount": 11,
            "Currency": "EUR",
            "MinQuantity": 6,
            "MaxQuantity": 99999,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "pistol",
                  "armor"
                ]
              }
            ]
          },
          {
            "Amount": 12,
            "Currency": "EUR",
            "MinQuantity": 6,
            "MaxQuantity": 99999,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "pistol"
                ]
              }
            ]
          },
          {
            "Amount": 13,
            "Currency": "EUR",
            "MinQuantity": 6,
            "MaxQuantity": 99999,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "bomb",
                  "armor"
                ]
              }
            ]
          },
          {
            "Amount": 14,
            "Currency": "EUR",
            "MinQuantity": 6,
            "MaxQuantity": 99999,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "bomb"
                ]
              }
            ]
          },
          {
            "Amount": 15,
            "Currency": "EUR",
            "MinQuantity": 6,
            "MaxQuantity": 99999,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "armor"
                ]
              }
            ]
          },
          {
            "Amount": 16,
            "Currency": "EUR",
            "MinQuantity": 6,
            "MaxQuantity": 99999,
            "OptionCodes": []
          }
        ],
        "Renewal": [
          {
            "Amount": 11,
            "Currency": "EUR",
            "MinQuantity": 1,
            "MaxQuantity": 5,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "pistol",
                  "bomb",
                  "armor"
                ]
              }
            ]
          },
          {
            "Amount": 12,
            "Currency": "EUR",
            "MinQuantity": 1,
            "MaxQuantity": 5,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "pistol",
                  "bomb"
                ]
              }
            ]
          },
          {
            "Amount": 13,
            "Currency": "EUR",
            "MinQuantity": 1,
            "MaxQuantity": 5,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "pistol",
                  "armor"
                ]
              }
            ]
          },
          {
            "Amount": 14,
            "Currency": "EUR",
            "MinQuantity": 1,
            "MaxQuantity": 5,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "pistol"
                ]
              }
            ]
          },
          {
            "Amount": 15,
            "Currency": "EUR",
            "MinQuantity": 1,
            "MaxQuantity": 5,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "bomb",
                  "armor"
                ]
              }
            ]
          },
          {
            "Amount": 16,
            "Currency": "EUR",
            "MinQuantity": 1,
            "MaxQuantity": 5,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "bomb"
                ]
              }
            ]
          },
          {
            "Amount": 17,
            "Currency": "EUR",
            "MinQuantity": 1,
            "MaxQuantity": 5,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "armor"
                ]
              }
            ]
          },
          {
            "Amount": 18,
            "Currency": "EUR",
            "MinQuantity": 1,
            "MaxQuantity": 5,
            "OptionCodes": []
          },
          {
            "Amount": 19,
            "Currency": "EUR",
            "MinQuantity": 6,
            "MaxQuantity": 99999,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "pistol",
                  "bomb",
                  "armor"
                ]
              }
            ]
          },
          {
            "Amount": 20,
            "Currency": "EUR",
            "MinQuantity": 6,
            "MaxQuantity": 99999,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "pistol",
                  "bomb"
                ]
              }
            ]
          },
          {
            "Amount": 21,
            "Currency": "EUR",
            "MinQuantity": 6,
            "MaxQuantity": 99999,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "pistol",
                  "armor"
                ]
              }
            ]
          },
          {
            "Amount": 22,
            "Currency": "EUR",
            "MinQuantity": 6,
            "MaxQuantity": 99999,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "pistol"
                ]
              }
            ]
          },
          {
            "Amount": 23,
            "Currency": "EUR",
            "MinQuantity": 6,
            "MaxQuantity": 99999,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "bomb",
                  "armor"
                ]
              }
            ]
          },
          {
            "Amount": 24,
            "Currency": "EUR",
            "MinQuantity": 6,
            "MaxQuantity": 99999,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "bomb"
                ]
              }
            ]
          },
          {
            "Amount": 25,
            "Currency": "EUR",
            "MinQuantity": 6,
            "MaxQuantity": 99999,
            "OptionCodes": [
              {
                "Code": "PERKS",
                "Options": [
                  "armor"
                ]
              }
            ]
          },
          {
            "Amount": 26,
            "Currency": "EUR",
            "MinQuantity": 6,
            "MaxQuantity": 99999,
            "OptionCodes": []
          }
        ]
      },
      "PriceOptions": [
        {
          "Code": "PERKS",
          "Required": false
        }
      ]
    }
  ],
  "Prices": [],
  "BundleProducts": [],
  "Fulfillment": "BY_VENDOR",
  "GeneratesSubscription": true,
  "SubscriptionInformation": {
    "DeprecatedProducts": [],
    "BillingCycle": 1,
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
      "Period": 5,
      "PeriodUnits": "D",
      "IsUnlimited": false
    }
  }
}
JSON;

return json_decode($response);