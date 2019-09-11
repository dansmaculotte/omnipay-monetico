<?php


namespace Omnipay\Monetico\Messages;

use DansMaCulotte\Monetico\Responses\RefundResponse as MoneticoRefund;
use Omnipay\Common\Message\AbstractResponse;

class RefundResponse extends AbstractResponse
{
    /**
     * RefundResponse constructor.
     * @param RefundRequest $request
     * @param string $data
     * @throws \DansMaCulotte\Monetico\Exceptions\Exception
     */
    public function __construct(RefundRequest $request, string $data)
    {
        $this->request = $request;
        $this->data = new MoneticoRefund(explode(PHP_EOL, $data));
    }

    /**
     * @return bool
     * @throws \DansMaCulotte\Monetico\Exceptions\Exception
     */
    public function isSuccessful()
    {
        return $this->data->returnCode === 0;
    }
}
