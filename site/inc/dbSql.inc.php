<!-- Filen som inneholder dbSetupSQL-funksjonen -->
<?php

function dbSetupSQL(): array
{
    $queries = array();

    // Opprettelse av tabell for romtyper
    $queries['createRoomTypesTable'] = "
        CREATE OR REPLACE TABLE room_types (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,         -- /* Romtype (f.eks. Enkeltrom, Dobbeltrom)
            max_adults INT NOT NULL,            -- Maks antall voksne
            max_children INT NOT NULL,          -- Maks antall barn
            description TEXT                    -- Beskrivelse av romtypen
        );
    ";

    // Opprettelse av tabell for individuelle rom
    $queries['createRoomsTable'] = "
        CREATE OR REPLACE TABLE rooms (
            id INT AUTO_INCREMENT PRIMARY KEY,
            room_number VARCHAR(10) NOT NULL,   -- Romnummer (f.eks. '101')
            room_type_id INT NOT NULL,          -- Kobling til romtypen (foreign key)
            status ENUM('available', 'booked') DEFAULT 'available', -- Status på rommet
            FOREIGN KEY (room_type_id) REFERENCES room_types(id)
        );
    ";

    // Opprettelse av tabell for romreservasjoner (bookinger)
    $queries['createBookingsTable'] = "
        CREATE OR REPLACE TABLE bookings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            room_id INT NOT NULL,               -- Kobling til rommet (foreign key)
            customer_name VARCHAR(100) NOT NULL, -- Navn på kunden
            customer_email VARCHAR(100) NOT NULL, -- Epost til kunden
            check_in DATE NOT NULL,             -- Innsjekkingsdato
            check_out DATE NOT NULL,            -- Utsjekkingsdato
            adults INT NOT NULL,                -- Antall voksne
            children INT NOT NULL,              -- Antall barn
            status ENUM('booked', 'checked_in', 'checked_out', 'cancelled') DEFAULT 'booked', -- Status på reservasjonen
            FOREIGN KEY (room_id) REFERENCES rooms(id)
        );
    ";

    // Opprettelse av tabell for brukere
    $queries['createUsersTable'] = "
        CREATE OR REPLACE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(50) NOT NULL,       -- Fornavn på brukeren
            lastname VARCHAR(50) NOT NULL,     -- Etternavn på brukeren
            username VARCHAR(50) NOT NULL UNIQUE, -- Unikt brukernavn
            email VARCHAR(100) NOT NULL UNIQUE,  -- Epost (unik)
            password VARCHAR(255) NOT NULL,       -- Hashet passord
            role ENUM('admin', 'user') DEFAULT 'user' -- Rollen til brukeren (admin eller vanlig bruker)
        );
    ";

    // Eksempeldata for romtyper
    $queries['insertRoomTypesData'] = "
        INSERT INTO room_types (name, max_adults, max_children, description) VALUES
        ('Enkeltrom', 1, 0, 'Enkeltrom med én enkeltseng'),
        ('Dobbeltrom', 2, 1, 'Dobbeltrom med én dobbeltseng'),
        ('Junior Suite', 2, 2, 'Romslig suite med plass til en familie på 4');
    ";

    // Eksempeldata for rom
    $queries['insertRoomsData'] = "
        INSERT INTO rooms (room_number, room_type_id, status) VALUES
        ('101', 1, 'available'),
        ('102', 2, 'available'),
        ('103', 2, 'available'),
        ('201', 3, 'available'),
        ('202', 3, 'available');
    ";

    // Eksempeldata for brukere (inkludert admin og vanlige brukere)
    $queries['insertUsersData'] = "
    INSERT INTO users (firstname, lastname, username, email, password, role) VALUES
    ('Tiril', 'Kleppe', 'Kleppe14', 'tiril@mail.com', '" . password_hash('123', PASSWORD_DEFAULT) . "', 'admin'),
    ('Mie', 'Nord', 'mienord', 'mie@mail.com', '" . password_hash('123', PASSWORD_DEFAULT) . "', 'user');
";


    $queries['insertRoomsData'] = "
    INSERT INTO rooms (room_number, room_type_id, status) VALUES
    ('101', 1, 'available'),
    ('102', 1, 'available'),
    ('103', 1, 'available'),
    ('104', 1, 'available'),
    ('105', 1, 'available'),
    ('106', 2, 'available'),
    ('107', 2, 'available'),
    ('108', 2, 'available'),
    ('109', 2, 'available'),
    ('110', 2, 'available'),
    ('111', 3, 'available'),
    ('112', 3, 'available'),
    ('113', 3, 'available'),
    ('114', 3, 'available'),
    ('115', 3, 'available'),
    ('116', 1, 'available'),
    ('117', 1, 'available'),
    ('118', 2, 'available'),
    ('119', 2, 'available'),
    ('120', 3, 'available'),
    ('121', 3, 'available'),
    ('122', 1, 'available'),
    ('123', 1, 'available'),
    ('124', 2, 'available'),
    ('125', 3, 'available');
";

    return $queries;
}
