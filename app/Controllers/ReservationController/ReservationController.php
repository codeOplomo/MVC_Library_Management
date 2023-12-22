<?php

namespace App\Controllers\BookController;
require_once __DIR__ . '/../../../vendor/autoload.php';

use PDOException;
use Exception;

use App\Models\EntityImplementation\CrudEntity;
class ReservationController
{
    use CrudEntity;


    public function reserveBook($bookId)
    {
        try {
            $book = $this->findById($bookId);

            if ($book->checkAvailability()) {
                $member = $this->getCurrentMember();

                $reservationData = [
                    'book_id' => $bookId,
                    'member_id' => $member->getId(),
                ];

                $insertedId = $this->save($reservationData);

                $book->decreaseAvailableCopies();
                $this->modify(['available_copies' => $book->getAvailableCopies()], $bookId);

                // Save reservation and book changes to the database

                return ['status' => true, 'message' => 'Book reserved successfully.'];
            } else {
                return ['status' => false, 'message' => 'Book is not available for reservation.'];
            }
        } catch (Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    private function getCurrentMember()
    {
        session_start();

        if (isset($_SESSION['role']) && $_SESSION['role'] === 'Member' && isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            $userData = $this->read($user_id);

            // You might have a User class or similar to represent the logged-in user
            // Adjust this part based on your actual User class or structure
            $member = new User($userData['user_id'], $userData['username'], 'Member');
            return $member;
        } else {
            // If not authenticated or not a member, throw an exception or return null
            throw new Exception('User is not authenticated as a Member.');
        }
    }

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