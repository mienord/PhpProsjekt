<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Hent verdier fra skjemaet
    $checkin = $_POST['innsjekk'];
    $checkout = $_POST['utsjekk'];
    $adults = $_POST['voksne'];
    $children = $_POST['barn'];

    // Validering (kan utvides etter behov)
    if (strtotime($checkin) >= strtotime($checkout)) {
        die("Ugyldige datoer: Utsjekkingsdato må være etter innsjekkingsdato.");
    }

    if ($adults < 1) {
        die("Antall voksne må være minst 1.");
    }

    // Eksempel på søkespørring (SQL)
    // Dette er bare en enkel demonstrasjon. I en ekte applikasjon må du bruke forberedt SQL-spørring for å unngå SQL-injeksjon.
    $sql = "SELECT * FROM rooms WHERE available_from <= '$checkin' AND available_to >= '$checkout' AND max_adults >= $adults AND max_children >= $children";

    // Her kobler vi til databasen og kjører spørringen
    // $conn = new mysqli("servername", "username", "password", "database");
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    // $result = $conn->query($sql);

    // Eksempel på hvordan du kan vise resultater
    // if ($result->num_rows > 0) {
    //     while($row = $result->fetch_assoc()) {
    //         echo "Rom ID: " . $row["id"]. " - Type: " . $row["room_type"]. "<br>";
    //     }
    // } else {
    //     echo "Ingen ledige rom funnet.";
    // }

    // $conn->close();

    // For testing uten databasekobling
    echo "Søker etter rom med innsjekkingsdato: $checkin, utsjekkingsdato: $checkout, antall voksne: $adults, antall barn: $children.";
}
