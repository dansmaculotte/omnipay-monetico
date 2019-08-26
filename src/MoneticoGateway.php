<?php

namespace Omnipay\Monetico;

use Omnipay\Common\AbstractGateway;

class MoneticoGateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Monetico';
    }
}
