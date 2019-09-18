<?php


namespace Omnipay\Monetico\Messages;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function __construct(PurchaseRequest $request, array $data)
    {
        parent::__construct($request, $data);
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isTransparentRedirect()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'POST';
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->data['url'];
    }

    public function getRedirectData()
    {
        return $this->data['fields'];
    }
}
