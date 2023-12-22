<?php

namespace App\Controllers\BookController;
require_once __DIR__ . '/../../../vendor/autoload.php';

use PDOException;
use Exception;
// use App\Database\DatabaseConnection;
use App\Models\EntityImplementation\BaseEntity;

use App\Models\EntityImplementation\CrudEntity;
class ReservationController
{
    use CrudEntity;


    // private $database;

    
    // public function __construct()
    // {
    //     $dbconfig = new DbConfig();
    //     $this->database = $dbconfig->getConnection();
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



if(isset($_POST["edit-submit"])){
    $reservation = new Reservation(null,null,null,null,null,null);
    $reservation->setId($_POST["id"]);
    $reservation->setDescription($_POST["description"]);
    $reservation->setReservationDate($_POST["reservation_date"]);
    $reservation->setReturnDate($_POST["return_date"]);
    $reservation->setIsReturned($_POST["is_returned"]);
    $reservation->setIdBook($_POST["id_book"]);
    $reservationimp = new ReservationController();
    try {
        $reservationimp->update($reservation);
        $path = "../../../views/reservation/show.php";
        header("Location: " . $path);
        exit;
    }

    catch (PDOException $e) {
        echo "Error updating book: " . $e->getMessage();

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}


if(isset($_POST["submit"])){
    $reservation = new Reservation(null,null,null,null,null,null);

    $reservation->setDescription($_POST["description"]);
    $reservation->setReservationDate($_POST["reservation_date"]);
    $reservation->setReturnDate($_POST["return_date"]);
    $reservation->setIsReturned($_POST["is_returned"]);
    $reservation->setIdBook($_POST["id_book"]);
    $reservationimp = new ReservationController();

    $reservationimp->save($reservation);
}