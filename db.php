<?php
// Databasekonfigurasjon
$host = 'localhost';         // Databasevert (typisk localhost)
$dbname = 'rombooking';      // Navnet på databasen
$username = 'root';          // Databasebrukernavn
$password = '';              // Databasepassord (la stå tom hvis ingen passord)

// Forsøk å opprette en tilkobling til databasen
try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Sett feilhåndtering til unntak
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Sett standard fetch-modus til assosiativ
        PDO::ATTR_EMULATE_PREPARES   => false,                  // Deaktiver emulering av forberedte spørringer
    ];

    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // Håndter tilkoblingsfeil
    echo 'Tilkoblingsfeil: ' . $e->getMessage();
    exit;
}
?>
