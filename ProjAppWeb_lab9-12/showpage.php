<?php
// Połączenie z bazą danych
global $conn;
include('cfg.php');

function PokazPodstrone($id)
{
    global $conn;
    $id_clear = htmlspecialchars($id);
    $query = "SELECT * FROM page_list WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $id_clear);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);

    // wywołanie strony z bazy
    if(empty($row['id'])){
        $web = '[nie_znaleziono_strony]';
    }
    else{
        $web = $row['page_content'];
    }
    return $web;
}

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    echo PokazPodstrone($id);
} else {
    echo "Nie podano id podstrony.";
}
