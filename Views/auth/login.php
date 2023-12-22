<?php
$pageTitle = 'Login';
include '../templates/header.php';

session_start();

$errors = $_SESSION['errors'] ?? [];
session_unset();
?>

<div class="flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-sm">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Login</h2>

        <form action="../../app/Controllers/UserController/Login.php" method="POST">
            <?php if (isset($errors['login'])): ?>
                <div class="mb-4 text-red-500">
                    <?php echo $errors['login']; ?>
                </div>
            <?php endif; ?>
            <!-- Email Field -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input class="shadow appearance-none border <?php echo isset($errors['email']) ? 'border-red-500' : ''; ?> rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="text" placeholder="Email">
                <?php if (isset($errors['email'])): ?>
                    <span class="text-red-500 text-xs italic"><?php echo $errors['email']; ?></span>
                <?php endif; ?>
            </div>

            <!-- Password Field -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input class="shadow appearance-none border <?php echo isset($errors['password']) ? 'border-red-500' : ''; ?> rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" placeholder="********">
                <?php if (isset($errors['password'])): ?>
                    <span class="text-red-500 text-xs italic"><?php echo $errors['password']; ?></span>
                <?php endif; ?>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Sign In
                </button>
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="/path-to-forgot-password">
                    Forgot Password?
                </a>
            </div>
        </form>
    </div>
</div>

</body>
<?php  include '..//templates/footer.php'; ?>
