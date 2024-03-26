<?php

namespace App\service;

use App\Repositories\ticketRepository;
use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\MollieApiClient;

require_once __DIR__ . '/../vendor/mollie/mollie-api-php/vendor/autoload.php';
class ticketService
{
    private ticketRepository $ticketRepository;

    private MollieApiClient $mollie;

    /**
     * @throws ApiException
     */
    public function __construct()
    {
        $this->ticketRepository = new ticketRepository();
        $this->mollie = new MollieApiClient();
        $this->mollie->setApiKey('test_uVFQArn7P2nxgxUv5DnnHTJPvvudER');

    }
    public function getOrderByUserId($userId)
    {
        return $this->ticketRepository->getOrderByUserId($userId);
    }

    public function DisplayEventsByUser($userId)
    {
        return $this->ticketRepository->DisplayEventsByUser($userId);
    }

    public function getOrderItemByUserId($userId)
    {
        return $this->ticketRepository->getOrderItemsByUserId($userId);
    }
    public function createOrderItem($newOrderItem, $orderId)
    {
         return $this->ticketRepository->createOrderItem($newOrderItem, $orderId);
    }
    public function getOrderIdByCustomerId($userId)
    {
        return $this->ticketRepository->getOrderIdByCustomerId($userId);
    }
    public function deleteOrderbyOrderId($orderItemId): void
    {
         $this->ticketRepository->deleteOrderbyOrderId($orderItemId);
    }

    public function getOrderIdByUserId($userId)
    {
        return $this->ticketRepository->getOrderItemIdByUserId($userId);
    }

    public function updateTotalPrice($orderId)
    {
       $this->ticketRepository->updateTotalPrice($orderId);
    }

    public function getTotalPrice($userId)
    {
       return $this->ticketRepository->getTotalPrice($userId);
    }
    public function getPaymentStatusFromMollie($paymentCode)
    {
        $payment = $this->mollie->payments->get($paymentCode);
        return $payment->status;
    }
    public function getPaymentMethod($paymentCode)
    {
        $payment = $this->mollie->payments->get($paymentCode);
        return $payment->method;
    }

    /**
     * @throws ApiException
     */
    public function createPayment($userId, $orderId, $amount, $description, $redirectUrl, $webhookUrl)
    {
        $paymentId = $this->ticketRepository->getPaymentIdByOrderId($orderId);
        if (!$paymentId) {
            $payment = $this->mollie->payments->create([
                "amount" => [
                    "currency" => "EUR",
                    "value" => $amount,
                ],
                "description" => "Order #{$userId}",
                "redirectUrl" => $redirectUrl . "?orderId=" . $orderId,
                "webhookUrl" => $webhookUrl,
            ]);
            $checkoutUrl = $payment->getCheckoutUrl();
            $paymentId=$this->ticketRepository->insertPaymentDetail($userId, $orderId, $payment->status, $payment->id, $checkoutUrl);
        }
        $checkoutUrl = $this->ticketRepository->getCheckoutUrl($orderId);


        echo "<script>window.location.replace('" . $checkoutUrl . "');</script>";

    }

    public function updatePaymentStatus($paymentCode, $newPaymentStatus)
    {
        $this->ticketRepository->updatePaymentStatus($paymentCode, $newPaymentStatus);
    }

    public function changePaymentToPaid($paymentCode, $orderId)
    {
        $this->updatePaymentStatus($paymentCode, "Paid");
        $paymentMethod = $this->getPaymentMethod($paymentCode);
//        $this->ticketRepository->updatePaymentMethod($orderId, $paymentMethod); //TODO IT here
//        $this->ticketRepository->closeOrder($orderId);
//        $this->ticketRepository->decreasePerformanceTicketQuantityByOrderId($orderId);
//        $this->ticketRepository->decreaseHistoryTourTicketQuantityByOrderId($orderId);
    }

    public function getPaymentCodeByOrderId($orderId)
    {
        return $this->ticketRepository->getPaymentCode($orderId);

    }
}