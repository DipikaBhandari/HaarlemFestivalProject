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

    public function PaidOrders($userId)
    {
        return $this->ticketRepository->PaidOrders($userId);
    }

    public function DisplayEventsByUser($userId)
    {
        return $this->ticketRepository->DisplayEventsByUser($userId);
    }

    public function getOrderItemByUserId($userId)
    {
        return $this->ticketRepository->getOrderItemsByUserId($userId);
    }
    public function createOrderItem($newOrderItem)
    {
         return $this->ticketRepository->createOrderItem($newOrderItem);
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

    public function updateTotalPrice($userId)
    {
       $this->ticketRepository->updateTotalPrice($userId);
    }

    public function updateQuantity($orderItemId, $numberOfTickets)
    {
        $this->ticketRepository->updateQuantity($orderItemId, $numberOfTickets);
    }
    public function getOrderPriceById($orderItemId)
    {
        $this->ticketRepository->getOrderPriceById($orderItemId);
    }


    public function updatePrice($orderItemId, $price)
    {
       return $this->ticketRepository->updatePrice($orderItemId, $price);
    }

    public function updateOrderPrice($totalPrice, $userId)
    {
        return $this->ticketRepository->updateOrderPrice($totalPrice, $userId);
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

    public function closeOrder($orderId, $status)
    {
        $this->ticketRepository->closeOrder($orderId, $status);
    }

    public function updateOrderItemStatus($status, $orderId, $userId)
    {
        $this->ticketRepository->updateOrderItemStatus($status, $orderId, $userId);
    }

    public function updateOrderId($userId, $orderId)
    {
        $this->ticketRepository->updateOrderId($userId, $orderId);
    }
    public function createNewOrderId($userId)
    {
        return $this->ticketRepository->createNewOrder($userId);
    }
    public function changePaymentToPaid($paymentCode, $orderId)
    {
        $this->updatePaymentStatus($paymentCode, "paid");
        $this->closeOrder($orderId, "paid");

        $paymentMethod = $this->getPaymentMethod($paymentCode);

//        $this->ticketRepository->updatePaymentMethod($orderId, $paymentMethod); //TODO IT here

//        $this->ticketRepository->decreasePerformanceTicketQuantityByOrderId($orderId);
//        $this->ticketRepository->decreaseHistoryTourTicketQuantityByOrderId($orderId);
    }

    public function getPaymentCodeByOrderId($orderId)
    {
        return $this->ticketRepository->getPaymentCode($orderId);

    }
}