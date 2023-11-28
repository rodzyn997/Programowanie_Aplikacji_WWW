<?php
$servername = "localhost"; // Adres serwera baz danych (zazwyczaj localhost)
$username = "root"; // Nazwa użytkownika bazy danych (domyślnie root)
$password = ""; // Hasło dostępu do bazy danych

// Tworzenie połączenia
$conn = new mysqli($servername, $username, $password);

// Sprawdzenie połączenia
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";

    // Wybór konkretnej bazy danych
    $database_name = "moja_strona"; // Tutaj wpisz nazwę wybranej bazy danych
    if (!mysqli_select_db($conn, $database_name)) {
        die("Cannot select database");
    } else {
        echo "<br>Database selected successfully<br>";
    }

}
?>
