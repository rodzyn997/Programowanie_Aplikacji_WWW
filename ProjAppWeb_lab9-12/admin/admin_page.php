<?php
global $conn;
include('../cfg.php');
include ('../category.php');
include ('../produkty.php');
function ListaPodstron($conn) {
    $query = "SELECT id, page_title FROM page_list";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $output = "<h2>Lista dostępnych podstron:</h2>";
            $output .= "<ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= "<li>";
                $output .= "<a href='admin_page.php?edit=" . $row['id'] . "'>" . $row['page_title'] . "</a> ";
                $output .= "| <a href='admin_page.php?delete=" . $row['id'] . "'>Usuń</a>";
                $output .= "</li>";
            }
            $output .= "</ul>";
        } else {
            $output = "Brak dostępnych podstron.";
        }
    } else {
        $output = "Błąd zapytania do bazy danych: " . mysqli_error($conn);
    }

    return $output;
}

// Użycie funkcji ListaPodstron() z połączeniem do bazy danych
echo ListaPodstron($conn);

echo "<br></br> <b>Edycja</b>";
if (isset($_GET['edit'])) {
    echo EdytujPodstrone($conn, $_GET['edit']);
}
echo "<br> <b>Dodaj Nową stronę</b>";
echo DodajNowaPodstrone();


if (isset($_GET['delete'])) {
    echo UsunPodstrone($conn, $_GET['delete']);
}




?>


<?php
function EdytujPodstrone($conn, $id) {
$query = "SELECT * FROM page_list WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
$row = $result->fetch_assoc();

$output = "<form method='post' action='update_page.php'>";
    $output .= "<label for='title'>Tytuł:</label><br />";
    $output .= "<input type='text' id='title' name='title' value='" . $row['page_title'] . "' /><br />";
    $output .= "<label for='content'>Treść:</label><br />";
    $output .= "<textarea id='content' name='content'>" . $row['page_content'] . "</textarea><br />";
    $output .= "<label for='active'>Aktywna:</label><br />";
    $output .= "<input type='checkbox' id='active' name='active' " . ($row['active'] ? "checked" : "") . " /><br />";
    $output .= "<input type='hidden' name='id' value='" . $row['id'] . "' />";
    $output .= "<input type='submit' value='Zapisz zmiany' />";
    $output .= "</form>";

    
} else {
$output = "Nie znaleziono podstrony o id: " . $id;
}

return $output;
}

function UsunPodstrone($conn, $id) {
    $query = "DELETE FROM page_list WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    if ($result) {
        $output = "Podstrona o id: " . $id . " została usunięta.";
    } else {
        $output = "Błąd podczas usuwania podstrony: " . $stmt->error;
    }

    return $output;
}

function DodajNowaPodstrone() {
    $output = "<form method='post' action='add_page.php'>";
    $output .= "<label for='title'>Tytuł:</label><br />";
    $output .= "<input type='text' id='title' name='title' /><br />";
    $output .= "<label for='content'>Treść:</label><br />";
    $output .= "<textarea id='content' name='content'></textarea><br />";
    $output .= "<label for='active'>Aktywna:</label><br />";
    $output .= "<input type='checkbox' id='active' name='active' /><br />";
    $output .= "<input type='submit' value='Dodaj stronę' />";
    $output .= "</form>";

    return $output;
}

function WyswietlUzytkownikow($conn) {
    $query = "SELECT * FROM users";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $output = "<table>";
        $output .= "<tr><th>Password |</th><th>Nazwa użytkownika</th><th>Email</th></tr>";
        while($row = $result->fetch_assoc()) {
            $output .= "<tr>";
            $output .= "<td>" . $row['pass'] . "</td>";
            $output .= "<td>" . $row['name'] . "</td>";
            $output .= "<td>" . $row['email'] . "</td>";
            $output .= "</tr>";
        }
        $output .= "</table>";
    } else {
        $output = "Nie znaleziono żadnych użytkowników.";
    }

    return $output;
}
echo "<b>Uzytkownicy</b>";
echo WyswietlUzytkownikow($conn);
echo "<br>";


echo "
<style>
    .admin-panel {
        display: flex;
        justify-content: space-between;
    }
    .admin-section {
        width: 45%;
    }
</style>
";

echo "
<div class='admin-panel'>
    <div class='admin-section'>
";

echo "<b>Kategorie</b><br></br>";
$kategoria = new Kategoria($conn);
$kategoria->ZarzadzajKategoriami();

echo "
    </div>
    <div class='admin-section'>
";

echo "<b>Produkty</b>";
$produkt = new Produkt($conn);
$produkt->ZarzadzajProduktami();

echo "
    </div>
</div>
";


echo '
<style>
    form {
        margin: 20px 0;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    input, textarea {
        display: block;
        margin-bottom: 10px;
        padding: 10px;
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #45a049;
    }

</style>';
?>
