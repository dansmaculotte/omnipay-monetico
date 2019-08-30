<?php


namespace Omnipay\Monetico\Messages;

use DansMaCulotte\Monetico\Monetico;
use DansMaCulotte\Monetico\Requests\RefundRequest as MoneticoRefund;

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

        $monetico = $this->getMonetico();

        $refund = new MoneticoRefund([
            'reference' => $this->getTransactionId(),
            'language' => $this->getLanguage(),
            'dateTime' => new \DateTime(),
            'orderDate' => $this->getOrderDate(),
            'recoveryDate' => $this->getRecoveryDate(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'authorizationNumber' => $this->getTransactionReference(),
            'refundAmount' => $this->getRefundAmount(),
            'maxRefundAmount' => $this->getMaxRefundAmount(),
        ]);

        return [
            'fields' => $monetico->getFields($refund),
            'url' => MoneticoRefund::getUrl($this->getTestMode()),
        ];
    }

    public function sendData($data)
    {
        $headers = [];
        $body = http_build_query($data['fields'], '', '&');

        $response = $this->httpClient->request('POST', $data['url'], $headers, $body);

        var_dump($response->getBody()->getContents());
        die();

        $this->response = new RefundResponse($this, $response->getBody()->getContents());

        return $this->response;
    }

    /**
     * @return \DateTime
     */
    public function getOrderDate(): \DateTime
    {
        return $this->getParameter('orderDate');
    }

    /**
     * @param \DateTime $date
     */
    public function setOrderDate(\DateTime $date): void
    {
        $this->setParameter('orderDate', $date);
    }

    /**
     * @return \DateTime
     */
    public function getRecoveryDate(): \DateTime
    {
        return $this->getParameter('recoveryDate');
    }

    /**
     * @param \DateTime $date
     */
    public function setRecoveryDate(\DateTime $date): void
    {
        $this->setParameter('recoveryDate', $date);
    }

    /**
     * @return string
     */
    public function getRefundAmount(): string
    {
        return $this->getParameter('refundAmount');
    }

    /**
     * @param string $value
     */
    public function setRefundAmount(string $value): void
    {
        $this->setParameter('refundAmount', $value);
    }

    /**
     * @return string
     */
    public function getMaxRefundAmount(): string
    {
        return $this->getParameter('maxRefundAmount');
    }

    /**
     * @param string $value
     */
    public function setMaxRefundAmount(string $value): void
    {
        $this->setParameter('maxRefundAmount', $value);
    }
}
