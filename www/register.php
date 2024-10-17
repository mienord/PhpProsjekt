<html>

<head>
    <link rel="stylesheet" href="site/css/login.css?=v.1.0.1">
</head>

<div>

    <body>
        <div class="loginbox">
            <h1>Registrer deg som bruker</h1>
            <!-- Registreringsskjema som bruker POST-metoden -->
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <!-- Skjult felt som indikerer at skjemaet er sendt -->
                <input type="hidden" name="formSubmitted" value="1">
                <!-- Inputfelter for brukerens personlige informasjon -->
                Fornavn: <input type="text" name="firstname"><br>
                Etternavn: <input type="text" name="lastname"><br>
                Brukernavn: <input type="text" name="username"><br>
                Email: <input type="email" name="email"><br>
                Passord: <input type="password" name="password"><br>
                Er du admin? <input type="checkbox" name="role" value="1"><br>
                <button type="submit">Registrer deg</button><br>
            </form>
    </body>

    <?php
    require 'site/inc/db.inc.php';

    if (isset($_POST['formSubmitted'])) {

        // Oppretter en tom array for feilmeldinger
        $errorMessage = array();

        // Hent verdier fra skjemaet, og gjør dem trygge med htmlspecialchars
        $firstname = htmlspecialchars(ucfirst(strtolower($_POST['firstname'])));
        $lastname = htmlspecialchars(ucfirst(strtolower($_POST['lastname'])));
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        // Sjekker om "Er du admin?" er krysset av og setter rolle til enten 'admin' eller 'user'
        $role = isset($_POST['role']) && $_POST['role'] == '1' ? 'admin' : 'user';

        // Validerer at feltene er fylt ut og legger til passende feilmeldinger
        if (!$_POST['firstname']) {
            $errorMessage['A1'] = 'Fornavn må oppgis';
        }

        if (!$_POST['lastname']) {
            $errorMessage['A2'] = 'Etternavn må oppgis';
        }

        if (!$_POST['username']) {
            $errorMessage['A3'] = 'Brukernavn må oppgis';
        }

        if (!$_POST['email']) {
            $errorMessage['A4'] = 'Epost må oppgis';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage['A5'] = 'E-postadressen er ikke gyldig';
        }

        if (!$_POST['password']) {
            $errorMessage['A6'] = 'Passord må oppgis';
        }

        // Hvis det er noen feil, vis feilene
        if (!empty($errorMessage)) {
            echo "<ul class='error-list'>";
            foreach ($errorMessage as $val) {
                echo "<li class='error-message'>$val</li>";
            }
            echo "</ul>";
        } else {
            // Hvis ingen feil, fortsett med å lagre brukeren i databasen
            require 'site/inc/db.inc.php';

            // Hash passordet
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Forbered SQL-spørring for å sette inn ny bruker i databasen
            $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, username, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");

            // Utfør SQL-spørringen med data fra skjemaet
            if ($stmt->execute([$firstname, $lastname, $username, $email, $hashedPassword, $role])) {
                // Vellykket registrering
                $brukerData = array(
                    "Fornavn" => $firstname,
                    "Etternavn" => $lastname,
                    "Brukernavn" => $username,
                    "Email" => $email,
                    "Rolle" => $role
                );
                // Vis registreringssuksess og brukerens detaljer
                echo "Vellykket registrering! Brukeren er opprettet med denne informasjonen: ";
                echo "<div class='user-data'>";
                foreach ($brukerData as $key => $value) {
                    echo "<li><strong>$key:</strong> $value</li>";
                }
                echo "</div>";
                echo "<p>Etter vellykket registrering er du klar til å logge inn!</p>";
                echo '<button> <a href="login.php">Logg inn</button>';
            } else {
                echo "Registrering feilet.";
            }
        }
    }
    ?>
</div>
</div>

</html>