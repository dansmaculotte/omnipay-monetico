<?php

namespace Omnipay\Monetico;

use Omnipay\Common\AbstractGateway;
use Omnipay\Monetico\Messages\CompletePurchaseRequest;
use Omnipay\Monetico\Messages\PurchaseRequest;
use Omnipay\Monetico\Messages\RefundRequest;

class Gateway extends AbstractGateway
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Monetico';
    }

    /**
     * @return array
     */
    public function getDefaultParameters(): array
    {
        return [
            'eptCode' => '',
            'securityKey' => '',
            'companyCode' => '',
            'testMode' => false,
        ];
    }

    /**
     * @return string
     */
    public function getEptCode(): string
    {
        return $this->getParameter('eptCode');
    }

    /**
     * @param string $value
     * @return Gateway
     */
    public function setEptCode(string $value): self
    {
        return $this->setParameter('eptCode', $value);
    }

    /**
     * @return string
     */
    public function getSecurityKey(): string
    {
        return $this->getParameter('securityKey');
    }

    /**
     * @param string $value
     * @return Gateway
     */
    public function setSecurityKey(string $value): self
    {
        return $this->setParameter('securityKey', $value);
    }

    /**
     * @return string
     */
    public function getCompanyCode(): string
    {
        return $this->getParameter('companyCode');
    }

    /**
     * @param string $value
     * @return Gateway
     */
    public function setCompanyCode(string $value): self
    {
        return $this->setParameter('companyCode', $value);
    }

    /**
     * @param array $parameters
     * @return PurchaseRequest
     */
    public function purchase(array $parameters = []): PurchaseRequest
    {
        /** @var PurchaseRequest $request */
        $request = $this->createRequest(PurchaseRequest::class, $parameters);

        return $request;
    }

    /**
     * @param array $parameters
     * @return CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = []): CompletePurchaseRequest
    {
        /** @var CompletePurchaseRequest $request */
        $request = $this->createRequest(CompletePurchaseRequest::class, $parameters);

        return $request;
    }

    /**
     * @param array $parameters
     * @return RefundRequest
     */
    public function refund(array $parameters = []): RefundRequest
    {
        /** @var RefundRequest $request */
        $request = $this->createRequest(RefundRequest::class, $parameters);

        return $request;
    }
}
