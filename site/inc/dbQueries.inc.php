<?php

require_once '../site/inc/db.inc.php'; // Koble til databasen

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
    $sql = "SELECT rooms.room_number, room_types.name, rooms.status FROM rooms JOIN room_types ON rooms.room_type_id = room_types.id";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

// Legger til en ny booking
function createBooking($room_id, $customer_name, $customer_email, $check_in, $check_out, $adults, $children, $pdo)
{
    $sql = "
        INSERT INTO bookings (room_id, customer_name, customer_email, check_in, check_out, adults, children)
        VALUES (:room_id, :customer_name, :customer_email, :check_in, :check_out, :adults, :children)
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':room_id' => $room_id,
        ':customer_name' => $customer_name,
        ':customer_email' => $customer_email,
        ':check_in' => $check_in,
        ':check_out' => $check_out,
        ':adults' => $adults,
        ':children' => $children,
    ]);

    return $pdo->lastInsertId(); // Returnerer ID-en til den nye bookingen
}

// Henter booking informasjon for en spesifikk bruker (eller for alle)
function getBookings($pdo, $customer_email = null)
{
    if ($customer_email) {
        $sql = "SELECT * FROM bookings WHERE customer_email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $customer_email]);
    } else {
        $sql = "SELECT * FROM bookings";
        $stmt = $pdo->query($sql);
    }

    return $stmt->fetchAll();
}
