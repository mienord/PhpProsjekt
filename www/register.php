<?php
require '../site/inc/db.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Determine the role based on whether the checkbox is checked
    $role = isset($_POST['role']) && $_POST['role'] == '1' ? 'admin' : 'user';

    // Prepare SQL statement to include the role field
    $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, username, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");

    // Execute the query with data from the form
    if ($stmt->execute([$firstname, $lastname, $username, $email, $password, $role])) {
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
        <label for="firstname">Fornavn:</label>
        <input type="text" name="firstname" required><br>

        <label for="lastname">Etternavn:</label>
        <input type="text" name="lastname" required><br>

        <label for="username">Brukernavn:</label>
        <input type="text" name="username" required><br>

        <label for="email">E-post:</label>
        <input type="email" name="email" required><br>

        <label for="password">Passord:</label>
        <input type="password" name="password" required><br>

        <label for="role">Er du admin?</label>
        <input type="checkbox" name="role" value="1"><br>

        <button type="submit">Registrer</button>

        <p>Etter vellykket registrering er du klar til å logge inn!</p>
        <a href="login.php">Logg inn</a>
    </form>
</body>

</html>