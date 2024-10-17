<!DOCTYPE html>
<html lang="no">

<head>
    <link rel="stylesheet" href="site/css/main.css?=v2.0">
    <title>Booking bekreftelse</title>

</head>

<body>

    <div class="confirmation-container">
        <?php
        // Henter rom, insjekk & utsjekk dato, og romtype som ble bestilt
        if (isset($_GET['room_id'], $_GET['innsjekk'], $_GET['utsjekk'], $_GET['romtype'])) {
            $romnummer = $_GET['room_id'];
            $innsjekk = $_GET['innsjekk'];
            $utsjekk = $_GET['utsjekk'];
            $romtype = $_GET['romtype'];

            // Her kan du vise bekreftelse eller prosessere bookingen
            echo "<h1>Din booking er vellykket!</h1>";
            echo "<div class='booking-details'>";
            echo "<p>Du har booket romnummer: " . htmlspecialchars($romnummer) . "</p>";
            echo "<p>Innsjekk: " . htmlspecialchars($innsjekk) . "</p>";
            echo "<p>Utsjekk: " . htmlspecialchars($utsjekk) . "</p>";
            echo "<p>Romtype: " . htmlspecialchars($romtype) . "</p>";
        } else {
            echo "<p>Beklager, vi kunne ikke behandle bookingen din. Vennligst prøv igjen.</p>.";
        }
        ?>
    </div>

</body>

</html>