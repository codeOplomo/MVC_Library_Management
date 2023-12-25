<?php
namespace App\Models\Entity;

class Reservation {
    private $userId;
    private $bookId;
    private $description;
    private $reservationDate;
    private $returnDate;
    private $isReturned;

    public function __construct($userId, $bookId, $description, $returnDate, $isReturned) {
        $this->setUserId($userId);
        $this->setBookId($bookId);
        $this->setDescription($description);
        $this->setReservationDate();
        $this->setReturnDate($returnDate);
        $this->setIsReturned($isReturned);
    }

    public function toArray()
    {
        return [
            'userId' => $this->userId,
            'bookId' => $this->bookId,
            'description' => $this->description,
            'reservationDate' => $this->reservationDate,
            'returnDate' => $this->returnDate,
            'isReturned' => $this->isReturned,
        ];
    }

    protected function getTableName(): string
    {
        return 'reservation';
    }

    // Getters and setters
    public function getUserId() {
        return $this->userId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getBookId() {
        return $this->bookId;
    }

    public function setBookId($bookId) {
        $this->bookId = $bookId;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getReservationDate() {
        return $this->reservationDate;
    }

    public function setReservationDate() {
        $this->reservationDate = date('d/m/Y');
    }

    public function getReturnDate() {
        return $this->returnDate;
    }

    public function setReturnDate($returnDate) {
        $this->returnDate = $returnDate;
    }

    public function getIsReturned() {
        return $this->isReturned;
    }

    public function setIsReturned($isReturned) {
        $this->isReturned = $isReturned;
    }

    public function cancelReservation() {
        // Logic to cancel the reservation
    }

    public function isOverdue() {
        return strtotime($this->returnDate) < time();
    }
}
