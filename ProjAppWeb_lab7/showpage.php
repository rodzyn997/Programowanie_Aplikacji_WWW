<?php
// Połączenie z bazą danych
global $conn;
include('cfg.php'); // Załóżmy, że plik cfg.php zawiera połączenie z bazą danych

// Pobieranie treści strony na podstawie przekazanego aliasu lub ID (dla uproszczenia użyję aliasu)
if (isset($_GET['alias'])) {
    $alias = $_GET['alias'];

    // Zapytanie SQL
    $sql = "SELECT * FROM page_list WHERE alias = '$alias' LIMIT 1"; // Limit 1, bo zakładam unikalność aliasów

    // Wykonanie zapytania
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Wyświetlanie zawartości strony
        while ($row = $result->fetch_assoc()) {
            // Tutaj możesz użyć danych z bazy do wyświetlenia treści strony
            $page_title = $row['page_title'];
            $page_content = $row['page_content'];

            // Możesz wyświetlać treść strony w strukturze HTML
            echo "<!DOCTYPE html>
                <html>
                <head>
                    <title>$page_title</title>
                </head>
                <body>
                    <h1>$page_title</h1>
                    <div>
                        $page_content
                    </div>
                </body>
                </html>";
        }
    } else {
        echo "Brak danych dla podanego aliasu.";
    }
} else {
    echo "Nieprzekazano aliasu strony do wyświetlenia.";
}
?>
