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
                require_once '../site/inc/dbQueries.inc.php';

                $alle_rom = getAllRooms($pdo);

                // Vis romnummer og tilhørende romtype-informasjon
                foreach ($alle_rom as $rom) {
                    echo "<div class='room'>";
                    echo "<b>Romnummer: " . $rom['room_number'] . "</b><br>";
                    echo "Rom type: " . $rom['name'] . "<br>";
                    echo "Maks antall voksne: " . $rom['max_adults'] . "<br>";
                    echo "Maks antall barn: " . $rom['max_children'] . "<br><br>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <a href="logout.php">Logg ut</a>

</body>