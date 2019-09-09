<?php


namespace Omnipay\Monetico\Messages;

use DansMaCulotte\Monetico\Monetico;
use DansMaCulotte\Monetico\Requests\CaptureRequest as MoneticoCapture;
use DansMaCulotte\Monetico\Resources\ClientResource;

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

        $monetico = $this->getMonetico();

        $card = $this->getCard();

        $client = new ClientResource();
        $client->setParameter('civility', $card->getGender());
        $client->setParameter('firstName', $card->getFirstName());
        $client->setParameter('lastName', $card->getLastName());

        $capture = new MoneticoCapture([
            'reference' => $this->getTransactionId(),
            'language' => $this->getLanguage(),
            'dateTime' => new \DateTime(),
            'description' => $this->getDescription(),
            'email' => $card->getEmail(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'successUrl' => $this->getReturnUrl(),
            'errorUrl' => $this->getCancelUrl()
        ]);

        $capture->setClient($client);

        return [
            'fields' => $monetico->getFields($capture),
            'url' => MoneticoCapture::getUrl($this->getTestMode()),
        ];
    }

    public function sendData($data)
    {
        $this->response = new PurchaseResponse($this, $data);

        return $this->response;
    }
}
