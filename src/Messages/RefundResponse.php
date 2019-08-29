<?php


namespace Omnipay\Monetico\Messages;

use Omnipay\Common\Message\AbstractResponse;

class RefundResponse extends AbstractResponse
{
    public function __construct(RefundRequest $request, array $data)
    {
        parent::__construct($request, $data);

//        var_dump($data);
//        die();
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return false;
    }
}
