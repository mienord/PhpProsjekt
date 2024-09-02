<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Forbereder SQL-setningen for å sette inn data i users-tabellen
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    
    // Utfør spørringen med data fra skjemaet
    if ($stmt->execute([$username, $email, $password])) {
        echo "Registrering vellykket!";
    } else {
        echo "Registrering feilet.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrer deg</title>
</head>
<body>
    <h1>Registrer deg som bruker</h1>
    <form method="post">
        <label for="username">Brukernavn:</label>
        <input type="text" name="username" required><br>

        <label for="email">E-post:</label>
        <input type="email" name="email" required><br>

        <label for="password">Passord:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Registrer</button>
    </form>
</body>
</html>


