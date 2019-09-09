<?php


namespace Omnipay\Monetico\Messages;

use DansMaCulotte\Monetico\Monetico;
use Omnipay\Common\Http\ClientInterface;
use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractRequest extends OmnipayAbstractRequest
{
    /**
     * @return Monetico
     * @throws \DansMaCulotte\Monetico\Exceptions\Exception
     */
    public function getMonetico(): Monetico
    {
        return new Monetico(
            $this->getEptCode(),
            $this->getSecurityKey(),
            $this->getCompanyCode()
        );
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
     * @return PurchaseRequest
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
     * @return PurchaseRequest
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
     * @return PurchaseRequest
     */
    public function setCompanyCode(string $value): self
    {
        return $this->setParameter('companyCode', $value);
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->getParameter('language');
    }

    /**
     * @param string $value
     * @return PurchaseRequest
     */
    public function setLanguage(string $value): self
    {
        return $this->setParameter('language', $value);
    }
}
