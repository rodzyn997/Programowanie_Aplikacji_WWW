<?php
global $conn;
include('cfg.php');

function PokazKontakt() {
    $output = "<form method='post' action=''>";
    $output .= "<label for='email'>Email:</label><br />";
    $output .= "<input type='email' id='email' name='email' required /><br />";
    $output .= "<input type='submit' value='Przypomnij hasło' name='submit_przypomnij'>" ;
    $output .= "</form>";

    return $output;
}

echo PokazKontakt();

function WyslijMailKontakt($name, $pass, $email) {
    $to = 'test@xxxxx.com'; // Wpisz tutaj swój adres e-mail
    $subject = 'hasło dla konta ' . $name;
    $headers = 'From: ' . $email;

    $message = "Witaj $name,\n\nTwoje hasło to: $pass";

    if (mail($to, $subject, $message, $headers)) {
        echo "Wiadomość została wysłana.";
    } else {
        echo "Błąd podczas wysyłania wiadomości.";
    }
}

function PrzypomnijHaslo() {
    if (isset($_POST['submit_przypomnij'])) {
        // Pobierz e-mail z formularza POST
        global $conn;
        $email = $_POST['email'];

        // Sprawdzamy, czy e-mail istnieje w bazie danych
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            // Pobierz imię i haslo  użytkownika z bazy danych
            $user = $result->fetch_assoc();
            $name = $user['name'];
            $pass = $user['pass'];

            echo $name." twoje hasło to".$pass;
        } else {
            echo "Nie znaleziono użytkownika z takim adresem e-mail.";
        }
    }
}

echo PrzypomnijHaslo();

?>