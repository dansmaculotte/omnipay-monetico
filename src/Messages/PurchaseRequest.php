<?php


namespace Omnipay\Monetico\Messages;

use DansMaCulotte\Monetico\Monetico;
use DansMaCulotte\Monetico\Requests\PaymentRequest;
use DansMaCulotte\Monetico\Resources\ClientResource;
use Omnipay\Common\Message\AbstractRequest;

class PurchaseRequest extends AbstractRequest
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

        $card = $this->getCard();

        $client = new ClientResource(
            $card->getGender(),
            $card->getName(),
            $card->getFirstName(),
            $card->getLastName(),
            null
        );

        $payment = new PaymentRequest([
            'reference' => $this->getReference(),
            'language' => $this->getLanguage(),
            'dateTime' => new \DateTime(),
            'description' => $this->getDescription(),
            'email' => $card->getEmail(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'successUrl' => $this->getReturnUrl(),
            'errorUrl' => $this->getCancelUrl()
        ]);

        $payment->setClient($client);

        return [
            'fields' => $monetico->getFields($payment),
            'url' => PaymentRequest::getUrl($this->getTestMode()),
        ];
    }

    public function sendData($data)
    {
        $this->response = new PurchaseResponse($this, $data);

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
    public function getReference(): string
    {
        return $this->getParameter('reference');
    }

    /**
     * @param string $value
     * @return PurchaseRequest
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
     * @return PurchaseRequest
     */
    public function setLanguage(string $value): self
    {
        return $this->setParameter('language', $value);
    }
}
