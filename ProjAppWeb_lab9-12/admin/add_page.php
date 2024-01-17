<?php

global $conn;
include('../cfg.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $active = isset($_POST['active']) ? 1 : 0;

    $query = "INSERT INTO page_list (page_title, page_content, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $title, $content, $active);
    $result = $stmt->execute();

    if ($result) {
        echo "Podstrona została dodana.";
    } else {
        echo "Błąd podczas dodawania podstrony: " . $stmt->error;
    }
}

header('Location: admin_page.php');
?>