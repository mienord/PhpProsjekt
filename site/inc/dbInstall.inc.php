<!-- Filen som setter opp databasen -->

<?php
require_once 'db.inc.php';  // Inkluderer databaseforbindelsen fra db.php
require_once 'dbSql.inc.php';  // Filen som inneholder dbSetupSQL-funksjonen

// Hent spørringene for å opprette tabeller og sette inn eksempeldata
$queries = dbSetupSQL();

try {
    // Kjør alle spørringene
    foreach ($queries as $key => $sql) {
        $pdo->exec($sql);
        echo "$key ble utført vellykket.<br>";
    }
    echo "Databaseoppsettet er fullført.";
} catch (PDOException $e) {
    echo "Feil under databaseoppsett: " . $e->getMessage();
}
?>