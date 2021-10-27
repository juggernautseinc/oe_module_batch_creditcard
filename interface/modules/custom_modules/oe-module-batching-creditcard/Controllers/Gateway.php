<?php

/**
 *
 * @package      OpenEMR
 * @link               https://www.open-emr.org
 *
 * @author    Sherwin Gaddis <sherwingaddis@gmail.com>
 * @copyright Copyright (c) 2021 Sherwin Gaddis <sherwingaddis@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

namespace OpenEMR\Module\BatchCreditCard;

use Omnipay\Omnipay;

/**
 * Gateway class to handle the implementation of the credit card processing
 */
class Gateway
{
    /**
     * @var
     */
    public $cvv;
    /**
     * @var
     */
    public $customerId;
    /**
     * @var
     */
    public $expiry_mo;
    /**
     * @var
     */
    public $expiry_yr;
    /**
     * @var \Omnipay\Common\GatewayInterface
     */
    public $gateway;
    /**
     * @var
     */
    public $number;

    /**
     * initiate the connection to the merchange copany
     */
    public function __construct()
    {
        //TODO: build an interface because different merchant companies have different login types.

        $this->gateway = Omnipay::create('Paytrace_CreditCard');
        $this->gateway->setUserName('demo123')
            ->setPassword('demo123')
            ->setTestMode(true);
    }

    /**
     * @return string[]
     */
    public function cardData(): array
    {
        return [
            'number' => '4242424242424242',
            'expiry_mo' => '6',
            'expiry_yr' => '2023',
            'cvv' => '123'
        ];
    }

    /**
     * @return string[]
     */
    public function addressData(): array
    {
        return [
                "name"=> "Princess Leia ",
                "street_address"=> "8320 E. West St.",
                "city"=> "Spokane",
                "state"=> "WA",
                "zip"=> "84524"
            ];
    }

    /**
     * @return string|null
     */
    public function sendPurchase(): ?string
    {
        $response = $this->gateway->purchase(
            [
                'amount' => '10.00',
                'currency' => 'USD',
                'card' => $this->cardData()
            ]
        )->send();

        return $response->getMessage();
    }

    /**
     * @return string|null
     */
    public function storeCard(): ?string
    {
        $response = $this->gateway->capture(
            [
                "customer_id" => "customerTest122-Demo",
                "credit_card"=> $this->cardData(),
                "billing_address" => $this->addressData(),
            ]
        )->send();

        return $response->getMessage();
    }
}
