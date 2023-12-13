<?php

class Kontakt {
    public function PokazKontakt() {
        ?>
        <form action="wyslij_mail.php" method="post">
            <label for="email">Adres e-mail:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="wiadomosc">Treść wiadomości:</label><br>
            <textarea id="wiadomosc" name="wiadomosc" rows="4" cols="50" required></textarea><br><br>

            <input type="submit" value="Wyślij">
        </form>
        <?php
    }


    public function WyslijMailKontakt($adresEmail, $wiadomosc) {
        $temat = "Temat maila";
        $wiadomoscEmail = "Treść wiadomości: $wiadomosc";
        $naglowki = "From: nadawca@example.com";


        mail($adresEmail, $temat, $wiadomoscEmail, $naglowki);
    }


    public function PrzypomnijHaslo($adminEmail) {
        $haslo = "hasloWYHENEROWANE";

        $wiadomosc = "Twoje nowe hasło: " . $haslo;

        $this->WyslijMailKontakt($adminEmail, $wiadomosc);
    }

}



?>
