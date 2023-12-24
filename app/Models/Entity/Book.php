<?php

namespace App\Models;
use \Exception;
require __DIR__ . '/../../vendor/autoload.php';
use App\Models\EntityImplementation\BaseEntity;
use App\Models\EntityImplementation\CrudEntity;


class Book {

    use BaseEntity;
    use CrudEntity;
 
    private $borrowedBooks = [];

    public $title;
    public $authors = [];
    public $genre;
    public $description;
    public $publicationYear;
    public $totalCopies;
    public $availableCopies;
    

    protected function getTableName(): string {
        return 'book';
    }
        public function __construct(
            $title,
            $authors,
            $genre,
            $description,
            $publicationYear,
            $totalCopies,
            $availableCopies
        ) {
            $this->title = $title;
            $this->authors = $authors;
            $this->genre = $genre;
            $this->description = $description;
            $this->publicationYear = $publicationYear;
            $this->totalCopies = $totalCopies;
            $this->availableCopies = $availableCopies;
        }
    
        public function getAuthors(): array {
            return $this->authors;
        }
    
        public function addAuthor(string $author): void {
            $this->authors[] = $author;
        }

        public function checkAvailability(): bool {
            return $this->availableCopies > 0;
        }

        public function borrowBook(Book $book): array {
            try {
                $this->validateBorrow($book);
        
                // Borrow the book
                $this->borrowedBooks[] = $book;
        
                // Update database logic (if applicable)
        
                return ['status' => true, 'message' => "Book '{$book->title}' has been borrowed by {$this->$book->title}"];
            } catch (Exception $e) {
                return ['status' => false, 'message' => $e->getMessage()];
            }
        }
        
}
