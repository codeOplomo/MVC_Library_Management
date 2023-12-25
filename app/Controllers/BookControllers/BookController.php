<?php

namespace App\Controllers\BookControllers;
require __DIR__ . '/../../../vendor/autoload.php';

use PDOException;
use Exception;
// use App\Database\DatabaseConnection;
use App\Models\EntityImplementation\BaseEntity;

use App\Models\EntityImplementation\CrudEntity;


class BookController
{
    use CrudEntity;
    use BaseEntity;
    protected function getTableName(): string
    {
        return 'book';
    }


    public function save($bookData)
    {
        try {
            $insertedId = $this->create($bookData, $this->getTableName());

            if ($insertedId) {
                return ['status' => true, 'message' => 'Book registration successful.', 'book_id' => $insertedId];
            } else {
                return ['status' => false, 'message' => 'Failed to register the book.'];
            }
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Failed to register the book.'];
        }
    }



public function modify($book)
{
    try {

        $bookId = $book->getId();

        if (!$bookId) {
            throw new Exception("Invalid book ID.");
        }

        $bookData = [
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'genre' => $book->getGenre(),
            'description' => $book->getDescription(),
            'publicationYear' => $book->getPublicationYear(),
            'totalCopies' => $book->getTotalCopies(),
            'available_copies' => $book->getAvailableCopies(),
        ];

        $this->update($bookData, $bookId);

        return true;
    }catch (Exception $e) {
        // Log or handle the error appropriately
        throw new Exception($e->getMessage());
    }
}



public function findById($id)
{
    try {
        $result = $this->read($id);

        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}


public function findAll()
{
    try {
        $result = $this->readAll();

        return $result;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return [];
    }
}


public function deleteById($id)
{
    $this->delete('id', $id);
}
}
