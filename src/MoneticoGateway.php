<?php

namespace Omnipay\Monetico;

use DansMaCulotte\Monetico\Monetico;
use Omnipay\Common\AbstractGateway;
use Omnipay\Monetico\Messages\Requests\AuthorizeRequest;
use Omnipay\Monetico\Messages\Requests\CaptureRequest;
use Omnipay\Monetico\Messages\Requests\CompleteAuthorizeRequest;
use Omnipay\Monetico\Messages\Requests\CompletePurchaseRequest;
use Omnipay\Monetico\Messages\Requests\PurchaseRequest;
use Omnipay\Monetico\Messages\Requests\RefundRequest;

class MoneticoGateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Monetico';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return [
            'ept_code' => null,
            'security_key' => null,
            'company_code' => null,
            'debug' => false
        ];
    }

    /**
     * @return string
     */
    public function getEptCode()
    {
        return $this->getParameter('ept_code');
    }

    /**
     * @param string $value
     * @return MoneticoGateway
     */
    public function setEptCode($value)
    {
        return $this->setParameter('ept_code', $value);
    }

    /**
     * @return string
     */
    public function getSecurityKey()
    {
        return $this->getParameter('security_key');
    }

    /**
     * @param string $value
     * @return MoneticoGateway
     */
    public function setSecurityKey($value)
    {
        return $this->setParameter('security_key', Monetico::getUsableKey($value));
    }

    /**
     * @return string
     */
    public function getCompanyCode()
    {
        return $this->getParameter('company_code');
    }

    /**
     * @param string $value
     * @return MoneticoGateway
     */
    public function setCompanyCode($value)
    {
        return $this->setParameter('company_code', $value);
    }

    /**
     * @return bool
     */
    public function getDebug()
    {
        return $this->getParameter('debug');
    }

    /**
     * @param boolean $value
     * @return MoneticoGateway
     */
    public function setDebug($value)
    {
        return $this->setParameter('debug', $value);
    }

    /**
     * @param array $options
     * @return AuthorizeRequest
     */
    public function authorize(array $options = [])
    {
        /** @var AuthorizeRequest $request */
        $request = $this->createRequest(AuthorizeRequest::class, $options);

        return $request;
    }

    /**
     * @param array $options
     * @return CompleteAuthorizeRequest
     */
    public function completeAuthorize(array $options = [])
    {
        /** @var CompleteAuthorizeRequest $request */
        $request = $this->createRequest(CompleteAuthorizeRequest::class, $options);

        return $request;
    }

    /**
     * @param array $options
     * @return CaptureRequest
     */
    public function capture(array $options = [])
    {
        /** @var CaptureRequest $request */
        $request = $this->createRequest(CaptureRequest::class, $options);

        return $request;
    }

    /**
     * @param array $options
     * @return PurchaseRequest
     */
    public function purchase(array $options = [])
    {
        /** @var PurchaseRequest $request */
        $request = $this->createRequest(PurchaseRequest::class, $options);

        return $request;
    }

    /**
     * @param array $options
     * @return CompletePurchaseRequest
     */
    public function completePurchase(array $options = [])
    {
        /** @var CompletePurchaseRequest $request */
        $request = $this->createRequest(CompletePurchaseRequest::class, $options);

        return $request;
    }

    /**
     * @param array $options
     * @return RefundRequest
     */
    public function refund(array $options = [])
    {
        /** @var RefundRequest $request */
        $request = $this->createRequest(RefundRequest::class, $options);

        return $request;
    }
}
