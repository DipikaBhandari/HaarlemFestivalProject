<?php

namespace App\service;
use App\model\reservation;
use App\Repositories\ReservationRepository;

class reservationService
{
    private $reservationRepository;

    public function __construct() {
        $this->reservationRepository = new ReservationRepository();
    }

    public function getReservationDetails() {
        return $this->reservationRepository->getReservationDetails();
    }
    public function getSingleReservationDetails($orderItemId) {
        return $this->reservationRepository->getSingleReservationDetails($orderItemId);
    }
    public function updateReservationDetails($reservationData) {
        return $this->reservationRepository->updateReservationDetails($reservationData);
    }
    public function deactivateReservation($orderItemId) {
        return $this->reservationRepository->updateReservationStatus($orderItemId, 'deactivated');
    }
    public function addNewReservation(reservation $reservationDetails): int
    {

        return $this->reservationRepository->addNewReservation($reservationDetails);
    }
}