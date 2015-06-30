<?php
$response = '{
  "Type": "CHECKBOX",
  "Options": [
    {
      "Code": "pistol",
      "ScaleMin": 0,
      "ScaleMax": 0,
      "SubscriptionImpact": null,
      "PriceImpact": {
        "ImpactOn": "BASE",
        "Percent": 5,
        "Method": "PERCENT",
        "Amounts": [],
        "Impact": "ADD"
      },
      "Default": false,
      "Name": "Pistol",
      "Description": "This is a pistol",
      "Translations": [
        {
          "Name": "Pistol",
          "Description": "This is a pistol",
          "Language": "EN"
        }
      ]
    },
    {
      "Code": "bomb",
      "ScaleMin": 0,
      "ScaleMax": 0,
      "SubscriptionImpact": null,
      "PriceImpact": {
        "ImpactOn": "BASE",
        "Percent": 6,
        "Method": "PERCENT",
        "Amounts": [],
        "Impact": "ADD"
      },
      "Default": false,
      "Name": "Bomb",
      "Description": "This is a bomb",
      "Translations": [
        {
          "Name": "Bomb",
          "Description": "This is a bomb",
          "Language": "EN"
        }
      ]
    },
    {
      "Code": "armor",
      "ScaleMin": 0,
      "ScaleMax": 0,
      "SubscriptionImpact": null,
      "PriceImpact": {
        "ImpactOn": "BASE",
        "Percent": 7,
        "Method": "PERCENT",
        "Amounts": [],
        "Impact": "ADD"
      },
      "Default": false,
      "Name": "Armor",
      "Description": "This is an armor",
      "Translations": [
        {
          "Name": "Armor",
          "Description": "This is an armor",
          "Language": "EN"
        }
      ]
    }
  ],
  "Code": "PERKS",
  "Required": false,
  "Name": "Perks",
  "Description": "",
  "Translations": [
    {
      "Name": "Perks",
      "Description": null,
      "Language": "EN"
    }
  ]
}';
return json_decode($response);