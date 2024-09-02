<?php
session_start();

// Sjekk om brukeren er logget inn
if (!isset($_SESSION['user_id'])) {
    // Hvis ikke logget inn, omdiriger til login.php
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
</head>
<body>
    <h1>Velkommen til adminpanelet!</h1>
    <p>Hei, <?php echo htmlspecialchars($_SESSION['username']); ?>. Du er nå logget inn.</p>
    <a href="logout.php">Logg ut</a>
</body>
</html>
