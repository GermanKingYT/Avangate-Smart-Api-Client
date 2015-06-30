<?php
$response = '[
  {
    "ProductCode": 6000,
    "DisplayType": "cart",
    "DisplayInEmail": false,
    "Products": [
      {
        "ProductCode": 3001,
        "Discount": 0,
        "DiscountType": "PERCENT"
      }
    ],
    "CampaignCode": "2Xrl83GEpeuCr3G3c6+9cg==",
    "Name": "TEST CAMPAIGN",
    "StartDate": null,
    "EndDate": null
  }
]';
echo json_decode($response);