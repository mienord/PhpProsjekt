<html>

<head>
    <link rel="stylesheet" href="site/css/main.css?=v1.2.1">
</head>

<body>

    <?php
    require_once 'site/inc/dbQueries.inc.php'; // Inkluderer filen med spørringer

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Hent data fra formen
        $innsjekk = $_POST['innsjekk'];
        $utsjekk = $_POST['utsjekk'];
        $voksne = (int) $_POST['voksne'];
        $barn = (int) $_POST['barn'];

        // Beregn totalt antall personer
        $total_personer = $voksne + $barn;

        // Bruk funksjonen for å hente ledige rom
        $ledige_rom = getAvailableRooms($innsjekk, $utsjekk, $voksne, $total_personer, $pdo);

        if (count($ledige_rom) > 0) {
            echo "<h2>Ledige rom</h2>",
            "<p>Her er en oversikt over ledige rom for dine valgte datoer:</p>";
            echo '<div class="room-container">';

            foreach ($ledige_rom as $rom) {
                echo '<div class="room-card">';
                echo '<div class="room-details">';
                echo '<h3>Romnummer: ' . $rom['room_number'] . ' (' . $rom['name'] . ')</h3>';
                echo '<div class="room-info">Maks voksne: ' . $rom['max_adults'] . '</div>';
                echo '<div class="room-info">Maks barn: ' . $rom['max_children'] . '</div><br>';
                // Send romnummer, innsjekkdato, utsjekkdato via URL-parametere
                echo '<a href="book_room.php?room_id=' . $rom['room_number'] .
                    '&innsjekk=' . urlencode($innsjekk) .
                    '&utsjekk=' . urlencode($utsjekk) .
                    '&romtype=' . urlencode($rom['name']) . '" class="book-room-btn">Bestill nå</a>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>'; // Slutt på room-container
        } else {
            echo "<p>Ingen ledige rom funnet for de angitte kriteriene.</p>";
        }
    }
    ?>
</body>

</html>