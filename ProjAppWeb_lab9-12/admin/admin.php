<?php
session_start();
include('../cfg.php');


function Zaloguj() {
    global $login, $pass;
    if (isset($_POST['x1_submit'])) {
        $login_email = $_POST['login_email'];
        $login_pass = $_POST['login_pass'];

        // Sprawdza, czy dane logowania są prawidłowe
        if (!empty($login_email) && !empty($login_pass) &&
        $login_email == $login && $login_pass == $pass) {
            // Zapisuje informacje o logowaniu w sesji
            $_SESSION['zalogowany'] = true;
            $_SESSION['login_email'] = $login_email;

            // Przekieruj do strony administracyjnej
            header('Location: admin_page.php');
            exit;
        } else {
            // Wyświetl komunikat o błędzie
            echo '<p class="error">Błędny adres e-mail lub hasło.</p>';
        }
    }

    // Wyświetl formularz logowania
    echo FormularzLogowania();

}

function FormularzLogowania()
{

    $wynik = '
    <link rel="stylesheet" type="text/css" href="../css/style3.css">
    <div class="logowanie">
        <h1 class="heading">Panel CMS:</h1>
        <div class="form-container">
            <form method="post" name="LoginForm" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '"> 
                <table class="log-table">
                    <tr>
                        <td class="log-label">Adres e-mail:</td>
                        <td><input type="text" name="login_email" class="log-input" /></td>
                    </tr> 
                    <tr>
                        <td class="log-label">Hasło:</td>
                        <td><input type="password" name="login_pass" class="log-input" /></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td><input type="submit" name="x1_submit" class="log-submit" value="Zaloguj" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>';

    return $wynik;
}
echo Zaloguj();

?>
