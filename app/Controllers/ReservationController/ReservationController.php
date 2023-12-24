<?php

namespace App\Controllers\BookController;
require_once __DIR__ . '/../../../vendor/autoload.php';

use PDOException;
use Exception;

use App\Models\EntityImplementation\CrudEntity;
use App\Models\Entity\User;
class ReservationController
{
    use CrudEntity;
    // use User;

    public function processReservation($reservedBooks, $returnDate)
{
    try {
        session_start();
        
        // Assuming you have a User class or similar to represent the logged-in user
        $userId = $_SESSION['user_id'];

        foreach ($reservedBooks as $book) {
            $reservationData = [
                'userId' => $userId,
                'bookId' => $book['id'], // Assuming you have an 'id' field for books
                'description' => $book['description'], // Adjust accordingly
                'reservationDate' => date('Y-m-d'), // Assuming you want to store the current date
                'returnDate' => $returnDate,
                'isReturned' => $book['quantity'], // Assuming 'quantity' is part of the book data
            ];

            error_log('Reservation Data: ' . print_r($reservationData, true));

            $insertedId = $this->save($reservationData);

            if ($insertedId) {
                echo 'reservation sucseed!!!!06!';
            } else {
                // Handle failed reservation
            }
        }

        return ['status' => true, 'message' => 'Reservation successful.'];

    } catch (Exception $e) {
        return ['status' => false, 'message' => 'Failed to process reservation.'];
    }
}



    // public function reserveBook($bookId, $returnDate)
    // {
    //     try {
    //         $book = $this->findById($bookId);

    //         if ($book->checkAvailability()) {
    //             $member = $this->getCurrentMember();

    //             $reservationData = [
    //                 'book_id' => $bookId,
    //                 'member_id' => $member->getId(),
    //                 'return_date' => $returnDate,
    //             ];

    //             $insertedId = $this->save($reservationData);

    //             $book->decreaseAvailableCopies();
    //             $this->modify(['available_copies' => $book->getAvailableCopies()], $bookId);

    //             return ['status' => true, 'message' => 'Book reserved successfully.'];
    //         } else {
    //             return ['status' => false, 'message' => 'Book is not available for reservation.'];
    //         }
    //     } catch (Exception $e) {
    //         return ['status' => false, 'message' => $e->getMessage()];
    //     }
    // }

    // private function getCurrentMember()
    // {
    //     session_start();

    //     if (isset($_SESSION['role']) && $_SESSION['role'] === 'Member' && isset($_SESSION['user_id'])) {
    //         $user_id = $_SESSION['user_id'];

    //         $userData = $this->read($user_id);

    //         // You might have a User class or similar to represent the logged-in user
    //         // Adjust this part based on your actual User class or structure
    //         $member = new User($userData['user_id'], $userData['username'], 'Member');
    //         return $member;
    //     } else {
    //         // If not authenticated or not a member, throw an exception or return null
    //         throw new Exception('User is not authenticated as a Member.');
    //     }
    // }

    public function save($reservationData)
    {
        try {
            $insertedId = $this->create($reservationData);

            if ($insertedId) {
                return ['status' => true, 'message' => 'Reservation successful.', 'reservation_id' => $insertedId];
            } else {
                return ['status' => false, 'message' => 'Failed to create reservation.'];
            }
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Failed to create reservation.'];
        }
    }

    public function modify($reservationData, $reservationId)
    {
        try {
            $this->update($reservationData, $reservationId);

            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
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


// Handle the reservation request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['role'] === 'Member' && isset($_SESSION['user_id'])) {
    try {
        echo 'reservation sucseed!!!!!';
        // Get the JSON data from the request body
        $requestData = json_decode(file_get_contents('php://input'), true);

        // Validate and process the data
        if (isset($requestData['reservedBooks']) && isset($requestData['returnDate'])) {
            $reservedBooks = $requestData['reservedBooks'];
            $returnDate = $requestData['returnDate'];

            // Process the reservation and return a response
            $response = $reservationController->processReservation($reservedBooks, $returnDate);

            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Invalid request data']);
            exit;
        }
    } catch (Exception $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
}

// if(isset($_POST["edit-submit"])){
//     $reservation = new Reservation(null,null,null,null,null,null);
//     $reservation->setId($_POST["id"]);
//     $reservation->setDescription($_POST["description"]);
//     $reservation->setReservationDate($_POST["reservation_date"]);
//     $reservation->setReturnDate($_POST["return_date"]);
//     $reservation->setIsReturned($_POST["is_returned"]);
//     $reservation->setIdBook($_POST["id_book"]);
//     $reservationimp = new ReservationController();
//     try {
//         $reservationimp->update($reservation);
//         $path = "../../../views/reservation/show.php";
//         header("Location: " . $path);
//         exit;
//     }

//     catch (PDOException $e) {
//         echo "Error updating book: " . $e->getMessage();

//     } catch (Exception $e) {
//         echo "Error: " . $e->getMessage();
//     }
// }


// if(isset($_POST["submit"])){
//     $reservation = new Reservation(null,null,null,null,null,null);

//     $reservation->setDescription($_POST["description"]);
//     $reservation->setReservationDate($_POST["reservation_date"]);
//     $reservation->setReturnDate($_POST["return_date"]);
//     $reservation->setIsReturned($_POST["is_returned"]);
//     $reservation->setIdBook($_POST["id_book"]);
//     $reservationimp = new ReservationController();

//     $reservationimp->save($reservation);
// }