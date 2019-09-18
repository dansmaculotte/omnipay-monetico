<?php


namespace Omnipay\Monetico\Messages;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    public function __construct(CompletePurchaseRequest $request, array $data)
    {
        parent::__construct($request, $data);
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return true;
    }
}
