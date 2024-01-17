<?php
$servername = "localhost"; // Adres serwera baz danych (zazwyczaj localhost)
$username = "root"; // Nazwa użytkownika bazy danych (domyślnie root)
$password = ""; // Hasło dostępu do bazy danych

$login= "admin";
$pass= "admin";

// Tworzenie połączenia
$conn = new mysqli($servername, $username, $password);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    echo "<span style='color: red;'>Connection failed: " . $conn->connect_error . "</span>";
} else {
    echo "<span style='color: green;'>Connected successfully</span>";

    // Wybór konkretnej bazy danych
    $database_name = "moja_strona"; // Tutaj wpisz nazwę wybranej bazy danych
    if (!mysqli_select_db($conn, $database_name)) {
        echo "<span style='color: red;'>Cannot select database</span>";
    } else {
        echo "<br><span style='color: green;'>Database selected successfully</span><br>";
    }

}
?>
