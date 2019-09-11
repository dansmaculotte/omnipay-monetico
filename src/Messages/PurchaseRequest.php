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
        if ($client) {
            $capture->setClient($client);
        }

        $billingAddress = $this->getBillingAddress();
        if ($billingAddress) {
            $capture->setBillingAddress($billingAddress);
        }

        $shippingAddress = $this->getShippingAddress();
        if ($shippingAddress) {
            $capture->setShippingAddress($shippingAddress);
        }

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

        $mapOmnipayToMonetico = [
            'gender' => 'civility',
            'firstName' => 'firstName',
            'lastName' => 'lastName',
            'name' => 'name',
            'birthday' => 'birthdate',
            'address1' => 'addressLine1',
            'address2' => 'addressLine2',
            'city' => 'city',
            'postcode' => 'postalCode',
            'country' => 'country',
            'state' => 'stateOrProvince',
            'phone' => 'phone'
        ];

        $parameters = [];
        foreach ($mapOmnipayToMonetico as $method => $key) {
            $method = 'get'.ucfirst($method);
            $parameter = $card->$method();
            if ($parameter) {
                $parameters[$key] = $parameter;
            }
        }

        if (count($parameters) === 0) {
            return null;
        }

        $client = new ClientResource($parameters);

        if ($client->getParameter('phone')) {
            $client->setParameter('phone', $card->getPhoneExtension() . $card->getPhone());
        }

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

    private function getAddress()
    {

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
