<?php

declare(strict_types=1);

namespace Paytic\Omnipay\Mobilpay\Message\Soap\Payment;

use Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Dto\Request;
use Paytic\Omnipay\Mobilpay\Api\Soap\Payment\Factory\RequestFactory;
use Paytic\Omnipay\Mobilpay\Utils\Traits\HasAuthTrait;
use Paytic\Omnipay\Mobilpay\Utils\Traits\HasOrderId;
use Paytic\Omnipay\Mobilpay\Utils\Traits\HasSecurityParams;

/**
 * Class DoPayTRequest
 * @package Paytic\Omnipay\Mobilpay\Message\Soap\Payment
 */
class DoPayTRequest extends AbstractPaymentSoapRequest
{
    use HasAuthTrait;
    use HasSecurityParams;
    use HasOrderId;

    /**
     * @inheritDoc
     */
    protected function runTransaction($soapClient, $data)
    {
        return $this->runSoapTransaction($soapClient, 'doPayT', $data);
    }

    public function getData()
    {
        $this->validate(
            'username',
            'password',
            'signature',
            'privateKey',
            'amount',
            'orderId'
        );

        return [
            'request' => $this->buildRequest(),
        ];
    }

    protected function buildRequest(): Request
    {
        return RequestFactory::fromMessage($this)->build();
    }

    /**
     * @return string
     */
    protected function getResponseClass()
    {
        return DoPayTResponse::class;
    }
}
