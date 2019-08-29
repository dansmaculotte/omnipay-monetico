<?php


namespace Omnipay\Monetico\Messages;

use DansMaCulotte\Monetico\Monetico;
use DansMaCulotte\Monetico\Requests\RefundRequest as MoneticoRefund;
use Omnipay\Common\Message\AbstractRequest;

class RefundRequest extends AbstractRequest
{
    /**
     * @return array
     * @throws \DansMaCulotte\Monetico\Exceptions\Exception
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
//        var_dump($this->getParameters());
//        die();

        $monetico = new Monetico(
            $this->getEptCode(),
            $this->getSecurityKey(),
            $this->getCompanyCode()
        );

        $refund = new MoneticoRefund([
            'reference' => $this->getTransactionId(),
            'language' => $this->getLanguage(),
            'dateTime' => new \DateTime(),
            'orderDatetime' => new \DateTime(),
            'recoveryDatetime' => new \DateTime(),
            'description' => $this->getDescription(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'authorizationNumber' => $this->getTransactionReference(),
            'refundAmount' => 50,
            'maxRefundAmount' => 80,
        ]);

        return [
            'fields' => $monetico->getFields($refund),
            'url' => MoneticoRefund::getUrl($this->getTestMode()),
        ];
    }

    public function sendData($data)
    {
        $this->response = new RefundResponse($this, $data);

        return $this->response;
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
     * @return CaptureRequest
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
     * @return CaptureRequest
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
     * @return CaptureRequest
     */
    public function setCompanyCode(string $value): self
    {
        return $this->setParameter('companyCode', $value);
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->getParameter('reference');
    }

    /**
     * @param string $value
     * @return CaptureRequest
     */
    public function setReference(string $value): self
    {
        return $this->setParameter('reference', $value);
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
     * @return CaptureRequest
     */
    public function setLanguage(string $value): self
    {
        return $this->setParameter('language', $value);
    }
}
