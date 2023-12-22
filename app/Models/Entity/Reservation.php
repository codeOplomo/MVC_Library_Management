<?php

class Reservation {
    public $userId;
    public $bookId;
    public $description;
    public $reservationDate;
    public $returnDate;
    public $isReturned;

    public function cancelReservation() {
        // Logic to cancel the reservation
    }

    public function isOverdue() {
        return strtotime($this->returnDate) < time();
    }
}
