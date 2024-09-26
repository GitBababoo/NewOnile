<?php
session_start();
require_once 'Database.php';
require_once 'GoogleAuth.php';
require_once 'User.php';

$db = new Database();
$user = new User($db);
$googleAuth = new GoogleAuth();

$error = null;

// Handle Form Submission
if (isset($_POST['register'])) { //More robust than checking REQUEST_METHOD
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING); //Sanitizing isn't enough for passwords!
    $phone_number = filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING);


    //Input validation: Check for empty fields
    if (empty($name) || empty($email) || empty($password)) {
        $error = "Please fill in all required fields.";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        //Password Hashing (Crucial for Security!!!)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); //Use password_hash

        $userId = $user->register($name, $email, $hashedPassword, $phone_number);
        if ($userId) {
            $_SESSION['user'] = ['id' => $userId, 'name' => $name, 'email' => $email, 'phone_number' => $phone_number];
            header('Location: login.php');
            exit();
        } else {
            $error = "Registration failed. Email address may already be in use.";
        }
    }
}

// Google Login Handling
if (isset($_GET['action']) && $_GET['action'] === 'login') {
    header('Location: ' . $googleAuth->getGoogleAuthUrl());
    exit();
}

if (isset($_GET['code'])) {
    try {
        $tokenData = $googleAuth->exchangeCodeForToken($_GET['code']);
        if (isset($tokenData['access_token'])) {
            $userData = $googleAuth->getGoogleUserInfo($tokenData['access_token']);

            $_SESSION['user'] = [
                'google_id' => $userData['sub'],
                'name' => $userData['name'],
                'email' => $userData['email'],
                'profile_picture' => $userData['picture']
            ];

            $registrationSuccessful = $user->registerWithGoogle(
                $_SESSION['user']['google_id'],
                $_SESSION['user']['name'],
                $_SESSION['user']['email'],
                $_SESSION['user']['profile_picture']
            );

            if ($registrationSuccessful) {
                $_SESSION['user']['id'] = $registrationSuccessful;
                header('Location: welcome.php');
                exit();
            } else {
                $error = "There was an error registering your Google account. Please try again later.";
            }
        } else {
            $error = "Error retrieving access token from Google: " . (isset($tokenData['error']) ? $tokenData['error'] : "Unknown error");
        }
    } catch (\Exception $e) {
        $error = "An error occurred during Google authentication: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .register-container {
            width: 400px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1); /* Subtle shadow */
        }
    </style>
</head>
<body>
<div class="container register-container">
    <h2 class="text-center mb-4">Register</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" id="phone_number" name="phone_number">
        </div>
        <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
    </form>
    <div class="mt-3 text-center">
        <a href="?action=login" class="btn btn-outline-primary w-100">Login with Google</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
