<?php
/*
 * Fusio
 * A web-application to create dynamically RESTful APIs
 *
 * Copyright (C) 2015-2018 Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Fusio\Adapter\Pabbly\Provider;

use Fusio\Engine\Model\ProductInterface;
use Fusio\Engine\Model\TransactionInterface;
use Fusio\Engine\ParametersInterface;
use Fusio\Engine\Payment\PrepareContext;
use Fusio\Engine\Payment\ProviderInterface;
// use PayPal\Api;
// use PayPal\Rest\ApiContext;
use PSX\Http\Exception as StatusCode;

/**
 * Paypal
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.gnu.org/licenses/agpl-3.0
 * @link    http://fusio-project.org
 */
class Pabbly implements ProviderInterface
{
    /**
     * @inheritdoc
     */
    public function prepare($connection, ProductInterface $product, TransactionInterface $transaction, PrepareContext $context)
    {
        $apiContext = $this->getApiContext($connection);

        // create payment
        // $payment = $this->createPayment($product, $context);
        // $payment->create($apiContext);

        // update transaction details
        $this->updateTransaction($transaction);

        return "Payment success";
        // return $payment->getApprovalLink();
    }

    /**
     * @inheritdoc
     */
    public function execute($connection, ProductInterface $product, TransactionInterface $transaction, ParametersInterface $parameters)
    {
        // $apiContext = $this->getApiContext($connection);

        // $payerId   = $parameters->get('PayerID');
        // $execution = new Api\PaymentExecution();
        // $execution->setPayerId($payerId);

        // // execute payment
        // $payment = Api\Payment::get($transaction->getRemoteId(), $apiContext);
        // $payment->execute($execution, $apiContext);

        // // update transaction details
        $this->updateTransaction($transaction);
    }

    /**
     * @param mixed $connection
     * @return \PayPal\Rest\ApiContext
     */
    private function getApiContext($connection)
    {
        return $connection;        
    }


    /**
     * @param \PayPal\Api\Payment $payment
     * @param \Fusio\Engine\Model\TransactionInterface $transaction
     */
    private function updateTransaction(TransactionInterface $transaction)
    {
        $transaction->setStatus($this->getTransactionStatus());
        // $transaction->setRemoteId($payment->getId());
        $transaction->setRemoteId("Pabbly-transac");
    }

    /**
     * @param \PayPal\Api\Payment $payment
     * @return integer
     */
    private function getTransactionStatus()
    {
        return TransactionInterface::STATUS_APPROVED;
    }
}
