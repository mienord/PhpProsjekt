<!DOCTYPE html>
<html lang="no">

<head>
    <link rel="stylesheet" href="site/css/main.css?=v7.09">
</head>

<body>
    <div class="tabs">
        <input type="radio" name="tabs" id="tabone" checked="checked">
        <label for="tabone">Hjem</label>
        <div class="tab">
            <h1>Velkommen til oss!</h1>
            <p>Her kan du booke et opphold hos oss! Velg dato og antall personer for å se hvilke rom som er tilgjengelig.</p>

            <h2>Søk etter overnatting</h2>
            <form action="search.php" method="POST">
                <div class="form-fields">
                    <div class="form-group">
                        <label for="innsjekk">Innsjekkingsdato:</label>
                        <input type="date" id="innsjekk" name="innsjekk" required>
                    </div>

                    <div class="form-group">
                        <label for="utsjekk">Utsjekkingsdato:</label>
                        <input type="date" id="utsjekk" name="utsjekk" required>
                    </div>

                    <div class="form-group">
                        <label for="voksne">Antall voksne:</label>
                        <input type="number" id="voksne" name="voksne" min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="barn">Antall barn:</label>
                        <input type="number" id="barn" name="barn" min="0" required>
                    </div>
                </div>

                <input type="submit" value="Søk">
            </form>

        </div>

        <input type="radio" name="tabs" id="tabtwo">
        <label for="tabtwo">Kontakt oss</label>
        <div class="tab">
            <h2>Tab Two Content</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>

        <input type="radio" name="tabs" id="tabthree">
        <label for="tabthree">idk enda</label>
        <div class="tab">
            <h2>Tab Three Content</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        </div>
    </div>

</body>

</html>