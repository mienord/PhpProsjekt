<?php

require_once 'db.inc.php'; // Koble til databasen

// Henter alle ledige rom basert på innsjekk, utsjekk, voksne og barn
function getAvailableRooms($innsjekk, $utsjekk, $voksne, $total_personer, $pdo)
{
    $sql = "
        SELECT rooms.room_number, room_types.name, room_types.max_adults, room_types.max_children
        FROM rooms
        JOIN room_types ON rooms.room_type_id = room_types.id
        WHERE rooms.id NOT IN (
            SELECT room_id
            FROM bookings
            WHERE (check_in <= :utsjekk AND check_out >= :innsjekk)
        )
        AND room_types.max_adults >= :voksne
        AND (room_types.max_adults + room_types.max_children) >= :total_personer
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':innsjekk' => $innsjekk,
        ':utsjekk' => $utsjekk,
        ':voksne' => $voksne,
        ':total_personer' => $total_personer,
    ]);

    return $stmt->fetchAll(); // Returnerer de ledige rommene
}

// Henter romdetaljer for adminsiden
function getAllRooms($pdo)
{
    $sql = "SELECT rooms.room_number, room_types.name, room_types.max_adults, room_types.max_children, room_types.description, rooms.status FROM rooms JOIN room_types ON rooms.room_type_id = room_types.id";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

//henter info om et spesifikt rom basert på romnummeret
function getRoomInfo($pdo, $room_number)
{
    $sql = "SELECT rooms.room_number, room_types.name, room_types.max_adults, room_types.max_children, room_types.description, rooms.status 
            FROM rooms 
            JOIN room_types ON rooms.room_type_id = room_types.id 
            WHERE rooms.room_number = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$room_number]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

//oppdaterer informasjonen om rommet basert på det adminen redigerte det til
function updateRoom($pdo, $room_number, $room_type, $max_adults, $max_children, $description, $status)
{
    $sql = "UPDATE rooms
                JOIN room_types ON rooms.room_type_id = room_types.id
                SET room_types.name = ?, room_types.max_adults = ?, room_types.max_children = ?, room_types.description = ?, rooms.status = ?
                WHERE rooms.room_number = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$room_type, $max_adults, $max_children, $description, $status, $room_number]);
}

function createBooking($pdo, $room_id, $customer_name, $customer_email, $check_in, $check_out, $adults, $children) {
    $sql = "INSERT INTO bookings (room_id, customer_name, customer_email, check_in, check_out, adults, children) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$room_id, $customer_name, $customer_email, $check_in, $check_out, $adults, $children]);
}

