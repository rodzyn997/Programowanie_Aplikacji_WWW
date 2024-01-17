<?php

global $conn;
include('../cfg.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $active = isset($_POST['active']) ? 1 : 0;

    $query = "UPDATE page_list SET page_title = ?, page_content = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssii", $title, $content, $active, $id);
    $result = $stmt->execute();

    if ($result) {
        echo "Podstrona została zaktualizowana.";
    } else {
        echo "Błąd podczas aktualizacji podstrony: " . $stmt->error;
    }
}

header("Location: ../showpage.php?id=" . $id);

?>
