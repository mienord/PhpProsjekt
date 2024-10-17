<?php
require 'site/inc/db.inc.php';

// Start a session if it hasn't already been started
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to find the user based on username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user) {
        // If the user is not found in the database
        echo "Brukeren ble ikke funnet.";
    } elseif ($user && password_verify($password, $user['password'])) {
        // If the password is correct, store user data in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];  // Store the user's role in the session

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header("Location: admin.php");
        } else if ($user['role'] === 'user') {
            header("Location: guest.php");
        } else {
            echo "Ukjent brukerrolle.";
        }
        exit;
    } else {
        // If the password doesn't match
        echo "Feil brukernavn eller passord.";
    }
}
?>

<!DOCTYPE html>
<html lang="no">

<head>
    <meta charset="UTF-8">
    <title>Logg inn</title>
    <link rel="stylesheet" href="site/css/login.css">
</head>

<body>
    <div class="loginbox">
        <form method="post">
            <h1>Logg inn</h1>
            <label for="username">Brukernavn:</label>
            <input type="text" name="username" required><br>

            <label for="password">Passord:</label>
            <input type="password" name="password" required><br>

            <button type="submit">Logg inn</button>
        </form>
    </div>
</body>

</html>