<?php


namespace Omnipay\Monetico\Messages;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        return [];
    }

    public function sendData($data)
    {
        $this->response = new CompletePurchaseResponse($this, $data);

        return $this->response;
    }
}
