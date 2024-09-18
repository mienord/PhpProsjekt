<?php
require 'db.php';

// Start a session if it hasn't already been started
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to find the user based on username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Store user data in the session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];  // Store the user's role in the session

        // Check the user's role and redirect accordingly
        if ($user['role'] === 'admin') {
            header("Location: admin.php");
        } else if ($user['role'] === 'guest') {
            header("Location: gjest.php");  // Changed 'gjest.php' to 'guest.php' for consistency
        } else {
            echo "Ukjent brukerrolle.";
        }
        exit;
    } else {
        echo "Feil brukernavn eller passord.";
    }
}
?>

<!DOCTYPE html>
<html lang="no">

<head>
    <meta charset="UTF-8">
    <title>Logg inn</title>
    <link rel="stylesheet" href="site/css/main.css?=v3.0">
</head>

<body>
    <div class="login">
        <h1>Logg inn</h1>
        <form method="post">
            <label for="username">Brukernavn:</label>
            <input type="text" name="username" required><br>

            <label for="password">Passord:</label>
            <input type="password" name="password" required><br>

            <button type="submit">Logg inn</button>
        </form>
    </div>
</body>

</html>