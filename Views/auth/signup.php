<?php

$pageTitle = 'Sign Up';
include '..//templates/header.php';
// require '../../app/Controllers/UserController/signupController.php';
?>

<div class="flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Sign Up</h2>
        <form action="../../app/Controllers/UserController/Register.php" method="POST">
            <!-- First Name -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="firstname">First Name</label>
                <input class="shadow appearance-none border <?php echo isset($errors['firstname']) ? 'border-red-500' : ''; ?> rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="firstname" name="firstname" type="text" placeholder="Full Name" value="<?php echo $formData['firstname'] ?? ''; ?>">
                <?php if (isset($errors['firstname'])): ?>
                    <span class="text-red-500 text-xs italic"><?php echo $errors['firstname']; ?></span>
                <?php endif; ?>
            </div>
            <!-- Last Name -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="lastname">Last Name</label>
                <input class="shadow appearance-none border <?php echo isset($errors['lastname']) ? 'border-red-500' : ''; ?> rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="lastname" name="lastname" type="text" placeholder="Last Name" value="<?php echo $formData['lastname'] ?? ''; ?>">
                <?php if (isset($errors['lastname'])): ?>
                    <span class="text-red-500 text-xs italic"><?php echo $errors['lastname']; ?></span>
                <?php endif; ?>
            </div>
            <!-- Phone -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">Phone</label>
                <input class="shadow appearance-none border <?php echo isset($errors['phone']) ? 'border-red-500' : ''; ?> rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="phone" name="phone" type="tel" placeholder="Phone Number" value="<?php echo $formData['phone'] ?? ''; ?>">
                <?php if (isset($errors['phone'])): ?>
                    <span class="text-red-500 text-xs italic"><?php echo $errors['phone']; ?></span>
                <?php endif; ?>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                <input class="shadow appearance-none border <?php echo isset($errors['email']) ? 'border-red-500' : ''; ?> rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="text" placeholder="Email" value="<?php echo $formData['email'] ?? ''; ?>">
                <?php if (isset($errors['email'])): ?>
                    <span class="text-red-500 text-xs italic"><?php echo $errors['email']; ?></span>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                <input class="shadow appearance-none border <?php echo isset($errors['password']) ? 'border-red-500' : ''; ?> rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" placeholder="Password">
                <?php if (isset($errors['password'])): ?>
                    <span class="text-red-500 text-xs italic"><?php echo $errors['password']; ?></span>
                <?php endif; ?>
            </div>

            

            <!-- Submit Button -->
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Sign Up</button>
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="/login">Already have an account?</a>
            </div>
        </form>
    </div>
</div>

</body>
<?php  include '..//templates/footer.php'; ?>
