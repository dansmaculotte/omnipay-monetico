<?php


namespace Omnipay\Monetico\Messages;

use DansMaCulotte\Monetico\Requests\PurchaseRequest as MoneticoPurchase;
use DansMaCulotte\Monetico\Resources\BillingAddressResource;
use DansMaCulotte\Monetico\Resources\CartItemResource;
use DansMaCulotte\Monetico\Resources\CartResource;
use DansMaCulotte\Monetico\Resources\ClientResource;
use DansMaCulotte\Monetico\Resources\ShippingAddressResource;
use Omnipay\Common\CreditCard;

class PurchaseRequest extends AbstractRequest
{
    /** @var CreditCard */
    protected $card;

    /**
     * @return array
     * @throws \DansMaCulotte\Monetico\Exceptions\Exception
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData()
    {
        $monetico = $this->getMonetico();

        $this->card = $this->getCard();

        $capture = new MoneticoPurchase([
            'reference' => $this->getTransactionId(),
            'language' => strtoupper($this->getLanguage()),
            'dateTime' => new \DateTime(),
            'description' => $this->getDescription(),
            'email' => $this->card->getEmail(),
            'amount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'successUrl' => $this->getReturnUrl(),
            'errorUrl' => $this->getCancelUrl(),
        ]);

        $client = $this->getClient();
        if ($client) {
            $capture->setClient($client);
        }

        $cart = $this->getCart();
        if ($cart) {
            $capture->setCart($cart);
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
            'url' => MoneticoPurchase::getUrl($this->getTestMode()),
        ];
    }

    /**
     * @return ClientResource
     * @throws \DansMaCulotte\Monetico\Exceptions\Exception
     */
    private function getClient()
    {
        $parameters = [
            'civility' => $this->card->getGender(),
            'firstName' => $this->card->getFirstName(),
            'lastName' => $this->card->getLastName(),
            'name' => $this->card->getName(),
            'birthdate' => $this->card->getBirthday(),
            'addressLine1' => $this->card->getAddress1(),
            'addressLine2' => $this->card->getAddress2(),
            'city' => $this->card->getCity(),
            'postalCode' => $this->card->getPostcode(),
            'country' => $this->card->getCountry(),
            'stateOrProvince' => $this->card->getState(),
            'phone' => $this->card->getPhone(),
        ];

        $client = new ClientResource();

        foreach ($parameters as $key => $value) {
            if ($value) {
                $client->setParameter($key, $value);
            }
        }

        if ($client->getParameter('phone')) {
            $client->setParameter('phone', $this->card->getPhoneExtension() . $this->card->getPhone());
        }

        return $client;
    }

    /**
     * @return BillingAddressResource
     * @throws \DansMaCulotte\Monetico\Exceptions\Exception
     */
    private function getBillingAddress()
    {
        $parameters = [
            'name' => $this->card->getBillingName(),
            'firstName' => $this->card->getBillingFirstName(),
            'lastName' => $this->card->getBillingLastName(),
            'addressLine1' => $this->card->getBillingAddress1(),
            'addressLine2' => $this->card->getBillingAddress2(),
            'city' => $this->card->getBillingCity(),
            'postalCode' => $this->card->getBillingPostcode(),
            'stateOrProvince' => $this->card->getBillingState(),
            'country' => $this->card->getBillingCountry(),
            'email' => $this->card->getEmail(),
            'phone' => $this->card->getBillingPhone(),
        ];

        $address = new BillingAddressResource();

        foreach ($parameters as $key => $value) {
            if ($value) {
                $address->setParameter($key, $value);
            }
        }

        if ($address->getParameter('phone')) {
            $address->setParameter('phone', $this->card->getBillingPhoneExtension() . $this->card->getBillingPhone());
        }

        return $address;
    }

    /**
     * @return ShippingAddressResource
     * @throws \DansMaCulotte\Monetico\Exceptions\Exception
     */
    private function getShippingAddress()
    {
        $parameters = [
            'name' => $this->card->getShippingName(),
            'firstName' => $this->card->getShippingFirstName(),
            'lastName' => $this->card->getShippingLastName(),
            'addressLine1' => $this->card->getShippingAddress1(),
            'addressLine2' => $this->card->getShippingAddress2(),
            'city' => $this->card->getShippingCity(),
            'postalCode' => $this->card->getShippingPostcode(),
            'stateOrProvince' => $this->card->getShippingState(),
            'country' => $this->card->getShippingCountry(),
            'email' => $this->card->getEmail(),
            'phone' => $this->card->getShippingPhone(),
        ];

        $address = new ShippingAddressResource();

        foreach ($parameters as $key => $value) {
            if ($value) {
                $address->setParameter($key, $value);
            }
        }

        if ($address->getParameter('phone')) {
            $address->setParameter('phone', $this->card->getShippingPhoneExtension() . $this->card->getShippingPhone());
        }

        return $address;
    }

    /**
     * @return CartResource
     * @throws \DansMaCulotte\Monetico\Exceptions\Exception
     */
    private function getCart()
    {
        $items = $this->getItems();

        if (count($items) === 0) {
            return null;
        }

        $cart = new CartResource();
        foreach ($items as $item) {
            $cartItem = new CartItemResource([
                'name' => $item->getName(),
                'description' => $item->getDescription(),
                'unitPrice' => $item->getPrice(),
                'quantity' => $item->getQuantity()
            ]);
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
