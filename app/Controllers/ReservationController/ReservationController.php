<?php

namespace App\Controllers\ReservationController;

require_once __DIR__ . '/../../../vendor/autoload.php';

use Exception;

use App\Models\EntityImplementation\CrudEntity;
use App\Models\Entity\Reservation;

class ReservationController
{
    use CrudEntity;

    protected function getTableName(): string
    {
        return 'reservation';
    }

    public function processReservation($reservedBooks, $returnDate)
    {
        try {
            session_start();

            // Assuming you have a User class or similar to represent the logged-in user
            if (isset($_SESSION['role']) && $_SESSION['role'] === 'Member' && isset($_SESSION['user_id'])) {

                $userId = $_SESSION['user_id'];

                foreach ($reservedBooks as $book) {

                    $bookId = $book['bookId'];
                    $description = $book['description'];
                    $quantity = $book['quantity'];

                    $reservationData = [
                        'userId' => $userId,
                        'bookId' => $bookId,
                        'description' => $description,
                        'returnDate' => $returnDate,
                        'quantity' => $quantity,
                    ];

                    $response = $this->save($reservationData);

                    if (!$response['status']) {
                        // Handle failed reservation
                        throw new Exception("Failed to create reservation. " . $response['message']);
                    }
                }

                return ['status' => true, 'message' => 'Reservation successful.'];
            } else {
                throw new Exception("Unauthorized access or missing session information.");
            }

        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Failed to process reservation: ' . $e->getMessage()];
        }
    }



    public function save($reservationData)
    {
        try {
            $insertedId = $this->create($reservationData, $this->getTableName());

            if ($insertedId) {
                return ['status' => true, 'message' => 'Reservation successful.', 'reservation_id' => $insertedId];
            } else {
                return ['status' => false, 'message' => 'Failed to create reservation.'];
            }
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Failed to create reservation. ' . $e->getMessage()];
        }
    }


    public function modify($reservationData, $reservationId)
    {
        try {
            $tableName = $this->getTableName();
            $this->update($reservationData, $reservationId, $tableName);
    
            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    

    public function findById($id)
    {
        try {
            $tableName = $this->getTableName();
            $result = $this->read($id, $tableName);
    
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    

    public function findAll()
    {
        try {
            $tableName = $this->getTableName();
            $result = $this->readAll($tableName);
    
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return [];
        }
    }
    
    public function deleteById($id)
    {
        try {
            $tableName = $this->getTableName();
            $this->delete('id', $id, $tableName);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    

}




// Assuming this code is in the part where you handle the reservation request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    if (isset($_SESSION['user_id'])) {
        try {
            $reservationController = new ReservationController();

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
    } else {
        header('HTTP/1.1 401 Unauthorized');
        echo json_encode(['error' => 'Unauthorized access']);
        exit;
    }
}