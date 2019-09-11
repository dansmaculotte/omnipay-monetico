<?php


namespace Omnipay\Monetico\Messages;

use DansMaCulotte\Monetico\Requests\CaptureRequest as MoneticoCapture;
use DansMaCulotte\Monetico\Resources\BillingAddressResource;
use DansMaCulotte\Monetico\Resources\CartItemResource;
use DansMaCulotte\Monetico\Resources\CartResource;
use DansMaCulotte\Monetico\Resources\ClientResource;
use DansMaCulotte\Monetico\Resources\ShippingAddressResource;

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

        $capture = new MoneticoCapture([
            'reference' => $this->getTransactionId(),
            'language' => strtoupper($this->getLanguage()),
            'dateTime' => new \DateTime(),
            'description' => $this->getDescription(),
            'email' => $card->getEmail(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'cart' => $this->getCart(),
            'successUrl' => $this->getReturnUrl(),
            'errorUrl' => $this->getCancelUrl(),
        ]);

        $client = $this->getClient();
        $capture->setClient($client);

        $billingAddress = $this->getBillingAddress();
        $capture->setBillingAddress($billingAddress);

        $shippingAddress = $this->getShippingAddress();
        $capture->setShippingAddress($shippingAddress);

        return [
            'fields' => $monetico->getFields($capture),
            'url' => MoneticoCapture::getUrl($this->getTestMode()),
        ];
    }

    /**
     * @return ClientResource
     * @throws \DansMaCulotte\Monetico\Exceptions\Exception
     */
    private function getClient()
    {
        $card = $this->getCard();

        $client = new ClientResource([
            'civility' => $card->getGender(),
            'firstName' => $card->getFirstName(),
            'lastName' => $card->getLastName(),
            'name' => $card->getName(),
            'birthdate' => $card->getBirthday(),
            'addressLine1' => $card->getAddress1(),
            'addressLine2' => $card->getAddress2(),
            'city' => $card->getCity(),
            'postalCode' => $card->getPostcode(),
            'country' => $card->getCountry(),
            'stateOrProvince' => $card->getState(),
            'phone' => $card->getPhoneExtension() . $card->getPhone(),
        ]);

        return $client;
    }

    /**
     * @return BillingAddressResource
     * @throws \DansMaCulotte\Monetico\Exceptions\Exception
     */
    private function getBillingAddress()
    {
        $card = $this->getCard();

        $address = new BillingAddressResource(
            $card->getBillingAddress1(),
            $card->getBillingCity(),
            $card->getBillingPostcode(),
            $card->getBillingCountry()
        );

        $address->setParameters([
            'name' => $card->getBillingName(),
            'firstName' => $card->getBillingFirstName(),
            'lastName' => $card->getBillingLastName(),
            'addressLine2' => $card->getBillingAddress2(),
            'stateOrProvince' => $card->getBillingState(),
            'email' => $card->getEmail(),
            'phone' => $card->getBillingPhoneExtension() . $card->getBillingPhone(),
        ]);

        return $address;
    }

    /**
     * @return ShippingAddressResource
     * @throws \DansMaCulotte\Monetico\Exceptions\Exception
     */
    private function getShippingAddress()
    {
        $card = $this->getCard();

        $address = new ShippingAddressResource(
            $card->getShippingAddress1(),
            $card->getShippingCity(),
            $card->getShippingPostcode(),
            $card->getShippingCountry()
        );

        $address->setParameters([
            'name' => $card->getShippingName(),
            'firstName' => $card->getShippingFirstName(),
            'lastName' => $card->getShippingLastName(),
            'addressLine2' => $card->getShippingAddress2(),
            'stateOrProvince' => $card->getShippingState(),
            'email' => $card->getEmail(),
            'phone' => $card->getShippingPhoneExtension() . $card->getShippingPhone(),
        ]);

        return $address;
    }

    /**
     * @return CartResource
     * @throws \DansMaCulotte\Monetico\Exceptions\Exception
     */
    private function getCart()
    {
        $items = $this->getItems();

        $cart = new CartResource();
        foreach ($items as $item) {
            $cartItem = new CartItemResource($item->getPrice(), $item->getQuantity());
            $cartItem->setParameter('name', $item->getName());
            $cartItem->setParameter('description', $item->getDescription());
            $cart->addItem($cartItem);
        }

        return $cart;
    }

    public function sendData($data)
    {
        $this->response = new PurchaseResponse($this, $data);

        return $this->response;
    }
}
