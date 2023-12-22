<?php
namespace App;
require __DIR__ . '/../../vendor/autoload.php';
use App\EntityImplementation\BaseEntity;
use App\EntityImplementation\CrudEntity;
use App\Models\Book;

use Exception;
class User{

    use BaseEntity;
    use CrudEntity;

    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $phone;
    private $budget;

    private $reservedBooks = [];
    
    private $borrowedBooks = [];
    
    private $maxBorrowedBooks;

    protected function getTableName(): string {
        return 'user';
    }

    public function __construct($maxBorrowedBooks = 3) {
        $this->maxBorrowedBooks = $maxBorrowedBooks;
    }

    public function getFullname() {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getReservedBooks() {
        return $this->reservedBooks;
    }

   /* public function borrowBook(Book $book): array {
         try {
            $this->validateBorrow($book);

            // Borrow the book
            $this->borrowedBooks[] = $book;
            $book->borrowedByUser($this); // Update the book entity

            // Update database logic (if applicable)

            return ['status' => true, 'message' => "Book '{$book->getTitle()}' has been borrowed by {$this->getFullname()}."];
        } catch (Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    } */

   /*  public function returnBook(Book $book) {
        try {
            $this->validateReturn($book);

            // Return the book
            $key = array_search($book, $this->borrowedBooks);
            unset($this->borrowedBooks[$key]);
            $book->returnedByUser($this); // Update the book entity

            // Update database logic (if applicable)

            return ['status' => true, 'message' => "Book '{$book->title}' has been returned by {$this->getFullname()}."];
        } catch (Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    } */


    private function validateReturn(Book $book) {
        // Check if the user has borrowed the book
        if (!in_array($book, $this->borrowedBooks)) {
            throw new Exception("You have not borrowed this book.");
        }
    }
}
