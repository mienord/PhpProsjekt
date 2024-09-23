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
    <link rel="stylesheet" href="site/css/main.css?=v1.0">
</head>

<body>
    <div class="tabs">

        <input type="radio" name="tabs" id="tabtwo" checked="checked">
        <label for="tabtwo">Velkommen</label>
        <div class="tab">
            <h2>Velkommen til adminpanelet!</h2>
            <p>Hei, <?php echo htmlspecialchars($_SESSION['username']); ?>. Du er nå logget inn.</p>
        </div>

        <input type="radio" name="tabs" id="tabthree">
        <label for="tabthree">Rom Oversikt</label>
        <div class="tab">
            <h2>Tab Three Content</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        </div>
    </div>

    <a href="logout.php">Logg ut</a>

</body>