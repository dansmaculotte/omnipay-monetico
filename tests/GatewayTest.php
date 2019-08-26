<?php

namespace Omnipay\Skeleton;

use Omnipay\Monetico\MoneticoGateway;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /** @var MoneticoGateway */
    protected $gateway;

    public function setUp()
    {
        parent::setUp();
        $this->gateway = new MoneticoGateway($this->getHttpClient(), $this->getHttpRequest());
    }
}
