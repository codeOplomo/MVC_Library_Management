<?php
namespace App\UserController;
require __DIR__ . '/../../../vendor/autoload.php';

use App\Controllers\UserController\Authentication;


$registrationError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['phone']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        
        $formData = [
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ];

        
        $formPassword = $formData['password'];

        if (
            !preg_match('/^[A-Za-z]{1,20}$/', $formData['firstname']) ||
            !preg_match('/^[A-Za-z]{1,20}$/', $formData['lastname']) ||
            strlen($formPassword) < 8 ||
            !preg_match('/[A-Za-z]/', $formPassword) ||
            !preg_match('/^\d{10}$/', $formData['phone']) ||
            !filter_var($formData['email'], FILTER_VALIDATE_EMAIL)
        ) {
            $registrationError = 'Invalid input. Please check your data.';
        } else {
            $firstname = htmlspecialchars($formData['firstname'], ENT_QUOTES, 'UTF-8');
            $lastname = htmlspecialchars($formData['lastname'], ENT_QUOTES, 'UTF-8');
            $phone = htmlspecialchars($formData['phone'], ENT_QUOTES, 'UTF-8');
            $email = htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8');
            $password = password_hash($formPassword, PASSWORD_DEFAULT);


            $validatedData = [
                'firstname' => $firstname,
                'lastname' =>$lastname,
                'phone' => $phone,
                'email' => $email,
                'password' => $password,
            ];
            
            $userAuth = new Authentication(); 
            $registrationResult = $userAuth->register($validatedData);

            if ($registrationResult['status']) {
                $userId = $registrationResult['user_id']; // Assuming your registration method returns the user ID
                $roleId = 3; // Assuming role "member" has ID 3
                $userAuth->insertUserRole($userId, $roleId);
                
                header('Location: ../../../Views/auth/login.php');
                exit();
            } else {
                $registrationError = 'Registration failed. Please try again.';
            }
        }
        echo $registrationError;

    }
}