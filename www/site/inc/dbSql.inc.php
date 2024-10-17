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
            status ENUM('tilgjengelig', 'booket') DEFAULT 'tilgjengelig', -- Status på rommet
            FOREIGN KEY (room_type_id) REFERENCES room_types(id)
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

    // Eksempeldata for romtyper
    $queries['insertRoomTypesData'] = "
        INSERT INTO room_types (name, max_adults, max_children, description) VALUES
        ('Enkeltrom', 1, 0, 'Enkeltrom med én enkeltseng'),
        ('Dobbeltrom', 2, 1, 'Dobbeltrom med én dobbeltseng'),
        ('Junior Suite', 2, 2, 'Romslig suite med plass til en familie på 4');
    ";

    // Eksempeldata for brukere (inkludert admin og vanlige brukere)
    $queries['insertUsersData'] = "
    INSERT INTO users (firstname, lastname, username, email, password, role) VALUES
    ('Tiril', 'Kleppe', 'Kleppe14', 'tiril@mail.com', '" . password_hash('123', PASSWORD_DEFAULT) . "', 'admin'),
    ('Mie', 'Nord', 'mienord', 'mie@mail.com', '" . password_hash('123', PASSWORD_DEFAULT) . "', 'user');
";

    $queries['insertRoomsData'] = "
    INSERT INTO rooms (room_number, room_type_id, status) VALUES
    ('101', 1, 'tilgjengelig'),
    ('102', 1, 'tilgjengelig'),
    ('103', 1, 'tilgjengelig'),
    ('104', 1, 'tilgjengelig'),
    ('105', 1, 'tilgjengelig'),
    ('106', 2, 'tilgjengelig'),
    ('107', 2, 'tilgjengelig'),
    ('108', 2, 'tilgjengelig'),
    ('109', 2, 'tilgjengelig'),
    ('110', 2, 'tilgjengelig'),
    ('111', 3, 'tilgjengelig'),
    ('112', 3, 'tilgjengelig'),
    ('113', 3, 'tilgjengelig'),
    ('114', 3, 'tilgjengelig'),
    ('115', 3, 'tilgjengelig'),
    ('116', 1, 'tilgjengelig'),
    ('117', 1, 'tilgjengelig'),
    ('118', 2, 'tilgjengelig'),
    ('119', 2, 'tilgjengelig'),
    ('120', 3, 'tilgjengelig'),
    ('121', 3, 'tilgjengelig'),
    ('122', 1, 'tilgjengelig'),
    ('123', 1, 'tilgjengelig'),
    ('124', 2, 'tilgjengelig'),
    ('125', 3, 'tilgjengelig');
";

    return $queries;
}
