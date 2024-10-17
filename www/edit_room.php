<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'site/inc/dbQueries.inc.php';

if (isset($_GET['room_id'])) {
    $room_number = $_GET['room_id'];
    $room = getRoomInfo($pdo, $room_number);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $room_type = $_POST['name'];
        $max_adults = $_POST['max_adults'];
        $max_children = $_POST['max_children'];
        $room_status = $_POST['status'];
        $room_description = $_POST['description'];

        // Oppdater rommet i databasen
        updateRoom($pdo, $room_number, $room_type, $max_adults, $max_children, $room_description, $room_status);
        // Omdiriger tilbake til romoversikten
        header("Location: admin.php");
        exit;
    }
} else {
    header("Location: admin.php");
    exit;
}
?>

<head>
    <link rel="stylesheet" href="site/css/login.css?=v1.7">
</head>

<body>
    <div class="loginbox">
        <h2>Rediger Rom</h2>
        <form method="post">
            <label>Rom type:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($room['name']); ?>"><br>

            <label>Maks antall voksne:</label>
            <input type="number" name="max_adults" value="<?php echo htmlspecialchars($room['max_adults']); ?>"><br>

            <label>Maks antall barn:</label>
            <input type="number" name="max_children" value="<?php echo htmlspecialchars($room['max_children']); ?>"><br>

            <label>Rom beskrivelse:</label>
            <input type="text" name="description" value="<?php echo htmlspecialchars($room['description']); ?>"><br>

            <label>Status:</label>
            <select name="status">
                <option value="tilgjengelig" <?php if ($room['status'] == 'tilgjengelig') echo 'selected'; ?>>Tilgjengelig</option>
                <option value="booket" <?php if ($room['status'] == 'booket') echo 'selected'; ?>>Booket</option>
            </select><br>
            <button type="submit">Lagre</button>
        </form>
    </div>
</body>