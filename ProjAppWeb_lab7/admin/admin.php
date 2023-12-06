<?php
session_start();
include('cfg.php');

$login = "admin";
$pass = "admin";
function FormularzLogowania()
{
    echo '
    <form method="post" action="">
        <label>Login:</label><br>
        <input type="text" name="login"><br>
        <label>Hasło:</label><br>
        <input type="password" name="pass"><br>
        <input type="submit" value="Zaloguj">
    </form>
    ';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredLogin = $_POST['login'];
    $enteredPass = $_POST['pass'];

    if ($enteredLogin === $login && $enteredPass === $pass) {
        $_SESSION['logged_in'] = true;
        // Tutaj można dodać inne dane do sesji, jeśli są potrzebne dla dalszych działań administracyjnych
        // $_SESSION['user'] = $enteredLogin;
        // ...

        // Przekierowanie na inną stronę po udanym logowaniu
        header('Location: inne_strony_administracyjne.php');
        exit();
    } else {
        echo "Błąd logowania. Spróbuj ponownie:<br>";
        FormularzLogowania();
    }
} else {
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        // Tutaj można umieścić kod dla zalogowanych użytkowników
        echo "Witaj, zalogowano jako admin!";
    } else {
        FormularzLogowania();
    }
}


function ListaPodstron()
{
    // Tutaj umieść logikę pobierania listy podstron, na potrzeby przykładu użyję tablicy z przykładowymi danymi
    $podstrony = [
        ['id' => 1, 'tytul' => 'Podstrona 1'],
        ['id' => 2, 'tytul' => 'Podstrona 2'],
        ['id' => 3, 'tytul' => 'Podstrona 3']
    ];

    echo '<h2>Lista Podstron:</h2>';
    echo '<table border="1">';
    echo '<tr><th>ID</th><th>Tytuł Podstrony</th><th>Akcje</th></tr>';

    foreach ($podstrony as $podstrona) {
        echo '<tr>';
        echo '<td>' . $podstrona['id'] . '</td>';
        echo '<td>' . $podstrona['tytul'] . '</td>';
        echo '<td>';
        echo '<button onclick="usunPodstrone(' . $podstrona['id'] . ')">Usuń</button>';
        echo '<button onclick="edytujPodstrone(' . $podstrona['id'] . ')">Edytuj</button>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';
}
?>

<!-- Dodatkowy skrypt JavaScript dla przykładu przycisków usuwania i edycji -->
<script>
    function usunPodstrone(id) {
        // Tutaj można umieścić logikę usuwania podstrony za pomocą AJAX lub przekierowania do odpowiedniego skryptu
        alert('Usuwanie podstrony o ID: ' + id);
    }

    function edytujPodstrone(id) {
        // Tutaj można umieścić logikę edycji podstrony, np. przekierowanie do formularza edycji
        alert('Edycja podstrony o ID: ' + id);
    }
</script>

<?php

ListaPodstron();
?>

<?php
function EdytujPodstrone()
{
    // Pobierz dane podstrony z bazy danych lub z innego miejsca (na potrzeby przykładu używam przykładowych danych)
    $podstrona = [
        'id' => 1,
        'tytul' => 'Tytuł podstrony',
        'tresc' => 'Treść podstrony',
        'aktywna' => true // Może to być wartość z bazy danych, oznaczająca czy strona jest aktywna czy nie
    ];

    echo '<h2>Edytuj Podstronę:</h2>';
    echo '<form method="post" action="zapisz_edycje.php">'; // Zmodyfikuj akcję formularza na skrypt, który będzie zapisywał zmiany
    echo '<input type="hidden" name="id" value="' . $podstrona['id'] . '">'; // Ukryte pole z id podstrony

    echo '<label>Tytuł:</label><br>';
    echo '<input type="text" name="tytul" value="' . $podstrona['tytul'] . '"><br>';

    echo '<label>Treść strony:</label><br>';
    echo '<textarea name="tresc">' . $podstrona['tresc'] . '</textarea><br>';

    echo '<label>Aktywna:</label>';
    echo '<input type="checkbox" name="aktywna" ' . ($podstrona['aktywna'] ? 'checked' : '') . '><br>';

    echo '<input type="submit" value="Zapisz zmiany">';
    echo '</form>';
}
?>

<!-- Wartości te mogą być zaciągnięte z bazy danych -->
<?php
EdytujPodstrone();
?>
<?php

function DodajNowaPodstrone()
{
    echo '<h2>Dodaj Nową Podstronę:</h2>';
    echo '<form method="post" action="">'; // Możesz tu podać skrypt obsługujący formularz

    echo '<label>Tytuł:</label><br>';
    echo '<input type="text" name="tytul"><br>';

    echo '<label>Treść strony:</label><br>';
    echo '<textarea name="tresc"></textarea><br>';

    echo '<label>Aktywna:</label>';
    echo '<input type="checkbox" name="aktywna"><br>';

    echo '<input type="submit" name="submit" value="Dodaj">';
    echo '</form>';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $tytul = $_POST['tytul'];
        $tresc = $_POST['tresc'];
        $aktywna = isset($_POST['aktywna']) ? 1 : 0; // Jeśli checkbox jest zaznaczony, wartość to 1, w przeciwnym razie 0

        // Zapytanie SQL typu INSERT
        $sql = "INSERT INTO tabela_podstron (tytul, tresc, aktywna) VALUES ('$tytul', '$tresc', '$aktywna')"; // Zmień "tabela_podstron" na właściwą nazwę tabeli w bazie danych


    }
}

DodajNowaPodstrone();

?>
