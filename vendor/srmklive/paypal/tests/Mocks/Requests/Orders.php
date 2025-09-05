<?php

namespace Srmklive\PayPal\Tests\Mocks\Requests;

use GuzzleHttp\Utils;

trait Orders
{
    /*
    * @return array
    */
    private function createOrderParams(): array
    {
<<<<<<< HEAD
        return Utils::jsonDecode('{
            "intent": "CAPTURE",
            "purchase_units": [
              {
                "amount": {
                  "currency_code": "USD",
                  "value": "100.00"
                }
              }
            ]
=======
        return Utils::jsonDecode('{
            "intent": "CAPTURE",
            "purchase_units": [
              {
                "amount": {
                  "currency_code": "USD",
                  "value": "100.00"
                }
              }
            ]
>>>>>>> f39eb1854d2944c0ca39f812f88e829928281819
          }', true);
    }

    /*
    * @return array
    */
    private function updateOrderParams(): array
    {
<<<<<<< HEAD
        return Utils::jsonDecode('[
        {
          "op": "replace",
          "path": "/purchase_units/@reference_id==\'PUHF\'/shipping/address",
          "value": {
            "address_line_1": "123 Townsend St",
            "address_line_2": "Floor 6",
            "admin_area_2": "San Francisco",
            "admin_area_1": "CA",
            "postal_code": "94107",
            "country_code": "US"
          }
        }
=======
        return Utils::jsonDecode('[
        {
          "op": "replace",
          "path": "/purchase_units/@reference_id==\'PUHF\'/shipping/address",
          "value": {
            "address_line_1": "123 Townsend St",
            "address_line_2": "Floor 6",
            "admin_area_2": "San Francisco",
            "admin_area_1": "CA",
            "postal_code": "94107",
            "country_code": "US"
          }
        }
>>>>>>> f39eb1854d2944c0ca39f812f88e829928281819
      ]', true);
    }
}
