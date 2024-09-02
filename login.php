<?php
require 'db.php';

// Start en sesjon hvis den ikke allerede er startet
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Forbered SQL-setningen for å finne brukeren basert på brukernavn
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Lagre brukerdata i sesjonen
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Omdiriger til admin.php
        header("Location: admin.php");
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
</head>
<body>
    <h1>Logg inn</h1>
    <form method="post">
        <label for="username">Brukernavn:</label>
        <input type="text" name="username" required><br>

        <label for="password">Passord:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Logg inn</button>
    </form>
</body>
</html>
