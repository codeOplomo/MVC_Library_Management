<?php
namespace App\UserController;

require __DIR__ . '/../../../vendor/autoload.php';

use App\Controllers\UserController\Authentication;

$loginError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $loginError = 'Invalid email address.';
        } else {
            
            $userAuth = new Authentication();

            $safeEmail = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
            $safePassword = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');

            $loginResult = $userAuth->login($safeEmail, $safePassword);

            if ($loginResult['status']) {
                echo'hmd4';
                $user = $userAuth->getEntityByField('email', $safeEmail);
                $userRole = $loginResult['user_role'];
                if ($userRole == 'Member') {
                    echo'hmd5';
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $userRole;
                    // $_SESSION['reservedBooks'] = [];
                    header('Location: ../../../Views/User/books.php');
                    exit();
                }
            } else {
                $loginError = 'Invalid email or password.';
            }
        }
    } else {
        $loginError = 'Please provide both email and password.';
    }
    echo $loginError;
}
?>