<?php
session_start();

// Sjekk om brukeren er logget inn
if (!isset($_SESSION['user_id'])) {
    // Hvis ikke logget inn, omdiriger til login.php
    header("Location: login.php");
    exit;
}
?>

<head>
    <link rel="stylesheet" href="../site/css/main.css?=v1.6">
</head>

<body>
    <div class="tabs">

        <input type="radio" name="tabs" id="tabtwo" checked="checked">
        <label for="tabtwo">Velkommen</label>
        <div class="tab">
            <h2>Velkommen til adminpanelet!</h2>
            <p>Hei, <?php echo htmlspecialchars($_SESSION['username']); ?>. Du er nå logget inn som administrator og har tilgang til å se og endre på rom.</p>
        </div>

        <input type="radio" name="tabs" id="tabthree">
        <label for="tabthree">Rom Oversikt</label>
        <div class="tab">
            <h2>Rom oversikt</h2>
            <p>Dette er en oversikt over rommene som er på motel TM.</p>
            <div class="romoversikt">
                <?php
                require_once '../site/inc/db.inc.php'; // Inkluderer tilkoblingen

                $sql = "
                SELECT rooms.room_number, room_types.name, room_types.max_adults, room_types.max_children
                FROM rooms
                JOIN room_types ON rooms.room_type_id = room_types.id
                ";

                $stmt = $pdo->query($sql); // Utfør spørringen
                $rooms = $stmt->fetchAll(); // Hent alle resultater

                // Vis romnummer og tilhørende romtype-informasjon
                foreach ($rooms as $room) {
                    echo "<div class='room'>";
                    echo "<b>Romnummer: " . $room['room_number'] . "</b><br>";
                    echo "Rom type: " . $room['name'] . "<br>";
                    echo "Maks antall voksne: " . $room['max_adults'] . "<br>";
                    echo "Maks antall barn: " . $room['max_children'] . "<br><br>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <a href="logout.php">Logg ut</a>

</body>