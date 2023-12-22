<?php
namespace App\Models\EntityImplementation;
require __DIR__ . '/../../../vendor/autoload.php';

use App\Models\Entity\Book;

use Exception;
trait BaseEntity {
    protected $id;
    protected $createdAt;
    protected $updatedAt;

    public function getId() {
        return $this->id;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }
    

    protected function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

    protected function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    private function validateBorrow($book) {
        if (count($this->borrowedBooks) >= $this->maxBorrowedBooks) {
            throw new Exception("You have reached the maximum number of borrowed books.");
        }

        if (!$book->checkAvailability()) {
            throw new Exception("The book is not available for borrowing.");
        }
    }
}
