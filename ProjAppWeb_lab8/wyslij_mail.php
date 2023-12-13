<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $wiadomosc = $_POST["wiadomosc"];

    require_once("contact.php");
    $kontakt = new Kontakt();
    $kontakt->WyslijMailKontakt($email, $wiadomosc);
}
?>

