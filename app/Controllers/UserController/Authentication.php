<?php
namespace App\Controllers\UserController;
require __DIR__ . '/../../../vendor/autoload.php';

use PDOException;
use Exception;
// use App\Database\DatabaseConnection;
use App\Models\EntityImplementation\BaseEntity;

use App\Models\EntityImplementation\CrudEntity;
class Authentication {

    use CrudEntity;
    use BaseEntity; 
    

    protected function getTableName(): string {
        // Return a custom table name for Authentication
        return 'user';
    }

    public function insertUserRole($userId, $roleId) {
        try {
            $pdo = self::getConnection();
    
            
            $stmt = $pdo->prepare("INSERT INTO roleuser (userId, roleId) VALUES (?, ?)");
            $stmt->execute([$userId, $roleId]);
    
            echo "User role inserted.\n";
        } catch (PDOException $e) {
            throw new Exception("Error inserting user role: " . $e->getMessage());
        }
    }
    
// Registration section

    public function register(array $formData) {

        $firstname = $formData['firstname'];
        $lastname = $formData['lastname'];
        $phone = $formData['phone'];
        $email = $formData['email'];
        $password = $formData['password'];
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['status' => false, 'message' => 'Invalid email address. Please provide valid information.'];
        }

        if ($this->getEntityByField('email', $email)) {
            return ['status' => false, 'message' => 'Email is already registered. Please choose a different one.'];
        }


        $userData = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'phone' => $phone,
            'email' => $email,
            'password' => $password,
        ];

        try {
            $insertedId = $this->create($userData);
            if ($insertedId) {
                return ['status' => true, 'message' => 'Registration successful.', 'user_id' => $insertedId];
            }else{
                return ['status' => false, 'message' => 'Failed to register the user.'];
            }
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Failed to register the user.'];
        }

    }


// Login section

public function login($email, $password) {
    // Modify this logic based on your authentication requirements
    $user = $this->getEntityByField('email', $email);
    if ($user && password_verify($password, $user['password'])) {

        $userId = $user['id'];
        $role = $this->getUserRole($userId);
        return ['status' => true, 'message' => 'Login successful.', 'user_role' => $role];
    }
    return ['status' => false, 'message' => 'Invalid email or password.'];
}
    

// Logout section

    public function logout() {
        session_destroy(); 
        return true;
    }
    
}
?>
