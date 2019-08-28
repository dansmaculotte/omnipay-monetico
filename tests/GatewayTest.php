<?php

namespace Omnipay\Monetico\Tests;

use DansMaCulotte\Monetico\Requests\PaymentRequest;
use Omnipay\Common\CreditCard;
use Omnipay\Monetico\Gateway;
use Omnipay\Monetico\Messages\AuthorizeResponse;
use Omnipay\Monetico\Messages\CaptureResponse;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /** @var Gateway */
    protected $gateway;

    /** @var CreditCard */
    protected $card;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setEptCode('1234567');
        $this->gateway->setSecurityKey('1036DEFD9175F29EE9337A1F284BDF781D5A4048');
        $this->gateway->setCompanyCode('dmc');
        $this->gateway->setTestMode(true);

        $this->card = new CreditCard([
            'firstName' => 'John',
            'lastName' => 'English',
            'email' => 'john@english.fr',
        ]);
    }

    public function testAuthorize()
    {
        /** @var AuthorizeResponse $response */
        $response = $this->gateway->authorize([
            'reference' => 'DMC123456789',
            'language' => 'FR',
            'amount' => '10.00',
            'currency' => 'EUR',
            'card' => $this->card,
            'returnUrl' => 'http://localhost/success',
            'cancelUrl' => 'http://localhost/error',
        ])->send();

        $this->assertInstanceOf(AuthorizeResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertNotNull($response->getRedirectUrl());
        $this->assertSame(PaymentRequest::getUrl(true), $response->getRedirectUrl());
        $this->assertTrue($response->isTransparentRedirect());
    }

    public function testCapture()
    {
        /** @var CaptureResponse $response */
        $response = $this->gateway->capture([
            'reference' => 'DMC123456789',
            'language' => 'FR',
            'amount' => '10.00',
            'currency' => 'EUR',
            'card' => $this->card,
            'returnUrl' => 'http://localhost/success',
            'cancelUrl' => 'http://localhost/error',
        ])->send();

        $this->assertInstanceOf(CaptureResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
    }
}
