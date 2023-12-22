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

        // private $database;

    // public function __construct()
    // {
    //     $db = new DbConfig();
    //     $this->database = $db->getConnection();
    // }


    public function save($bookData)
    {
        try {
            $insertedId = $this->create($bookData);

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



// if (isset($_POST['submit'])) {
//     $book = new Book(null,null,null,null,null,null,null);
//     $book->setTitle($_POST['title']);
//     $book->setAuthor($_POST['author']);
//     $book->setGenre($_POST['genre']);
//     $book->setDescription($_POST['description']);
//     $book->setPublicationYear($_POST['publication_year']);
//     $book->setTotalCopies($_POST['total_copies']);
//     $book->setAvailableCopies($_POST['available_copies']);
//     $bookimp = new BookController();
//     $bookimp->save($book);
// }


// if(isset($_POST['submit-edit'])) {
//     $book = new Book(null,null,null,null,null,null,null,null);
//     $book->setId($_POST["id"]);
//     $book->setTitle($_POST['title']);
//     $book->setAuthor($_POST['author']);
//     $book->setGenre($_POST['genre']);
//     $book->setDescription($_POST['description']);
//     $book->setPublicationYear($_POST['publication_year']);
//     $book->setTotalCopies($_POST['total_copies']);
//     $book->setAvailableCopies($_POST['available_copies']);
//     $bookimp = new BookController();

//     try {
//         $bookimp->modify($book);
//         $path = "../../../Views/User/books.php";
//         header("Location: " . $path);
//         exit;
//     }

//     catch (PDOException $e) {
//         echo "Error updating book: " . $e->getMessage();

//     } catch (Exception $e) {
//         echo "Error: " . $e->getMessage();
//     }
// }
