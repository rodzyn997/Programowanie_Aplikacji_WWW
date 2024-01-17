<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <meta name="Author" content="Bartosz Radzanowski" />
    <script src="js/kolorujtlo.js" type="text/javascript"></script>
    <script src="js/timedate.js" type="text/javascript"></script>

    <title>Żółwie wodne</title>
</head>
<body onload="startClock()">

<table>
    <tr>

        <td class="menu"><span> <a href="index.php"> Strona Główna </a> </td>
        <td class="menu"><a href="index.php?idp=zdj"> Galeria </a> </td>
        <td class="menu"> <a href="index.php?idp=onas"> O nas </a> </td>
        <td class="menu"><a href="index.php?idp=kontakt"> Kontakt </a> </td>
        <td class="menu"><a href="index.php?idp=info"> Nasze Produkty </a> </td>


    </tr>
</table>
<div class="poz" id="zegarek"></div>
<div class="poz"id="data"></div>
</body>
</html>

<?php
global $conn;
session_start();
include('cfg.php');

function dodajProduktDoKoszyka($id_produktu, $row) {
    $cena_brutto = $row['cena_netto'] * ($row['podatek_vat']) / 100;
    $cena_brutto += $row['cena_netto'];
    $zdjecie = $row['zdjecie'];

    // Sprawdź, czy produkt o danym ID już istnieje w koszyku
    if (isset($_SESSION['koszyk'][$id_produktu])) {
        // Zwiększ ilość istniejącego produktu o 1
        $_SESSION['koszyk'][$id_produktu]['ilosc'] += 1;
        header("Location: koszyk.php");
        exit();
    } else {
        // Dodaj produkt do koszyka
        $_SESSION['koszyk'][$id_produktu] = [
            'id' => $row['id'],
            'nazwa' => $row['tytul'],
            'cena' => $cena_brutto,
            'ilosc' => 1,
            'zdjecie' => $zdjecie
        ];
    }
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_produktu = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM produkty WHERE id = ?");
    $stmt->bind_param("i", $id_produktu);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Wyświetli dane produktu
        while ($row = $result->fetch_assoc()) {
            dodajProduktDoKoszyka($id_produktu, $row);
        }
    } else {
        echo "Produkt nie został znaleziony";
    }
}

// Wyświetl zawartość koszyka
echo '
<style>
    body {
        font-family: Arial, sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid black;
        padding: 15px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        margin: 10px 0;
        border: none;
        cursor: pointer;
    }

    button:hover {
        opacity: 0.8;
    }
</style>
';

echo '<table>';
echo '<tr><th>ID</th><th>Nazwa</th><th>Cena</th><th>Ilość</th><th>Usuń</th><th>Aktualizuj</th></tr>';
$total = 0;
foreach ($_SESSION['koszyk'] as $id_produktu => $produkt) {
    if ($produkt['ilosc'] > 0) {
        $suma = $produkt['cena'] * $produkt['ilosc'];
        $total += $suma;

        echo '<tr>';
        echo '<td><img src="data:image/*;base64,' . base64_encode($produkt['zdjecie']) . '" alt="zdjecie" height="140" width="160"></td>';
        echo '<td>' . $produkt['nazwa'] . '</td>';
        echo '<td>' . $produkt['cena'] . '</td>';
        echo '<td>' . $produkt['ilosc'] . '</td>';
        echo '<td>
            <form action="koszyk.php" method="post">
                <input type="hidden" name="id" value="' . $id_produktu . '">
                <input type="number" name="ilosc_usun" min="1" max="' . $produkt['ilosc'] . '">
                <button type="submit" name="usun">Usuń ilość</button>
            </form>
          </td>';
        echo '<td>
            <form action="koszyk.php" method="post">
                <input type="hidden" name="id" value="' . $id_produktu . '">
                <input type="number" name="ilosc" value="' . $produkt['ilosc'] . '">
                <button type="submit" name="aktualizuj">Aktualizuj ilość</button>
            </form>
          </td>';
        echo '</tr>';
    }
}

echo '<tr><td colspan="4">Suma całkowita</td><td>' . $total . ' PLN' . '</td></tr>';
echo '</table>';

// Usuń określoną ilość produktu z koszyka
if (isset($_POST['usun'])) {
    $id_produktu = $_POST['id'];
    $ilosc_usun = $_POST['ilosc_usun'];
    $_SESSION['koszyk'][$id_produktu]['ilosc'] -= $ilosc_usun;

    // Jeśli ilość produktu wynosi 0 lub mniej, usuń go z koszyka
    if ($_SESSION['koszyk'][$id_produktu]['ilosc'] <= 0) {
        unset($_SESSION['koszyk'][$id_produktu]);
    }

    // Przekieruj na koszyk po usunięciu
    header("Location: koszyk.php");
    exit();
}

// Aktualizuj ilość produktu w koszyku
if (isset($_POST['aktualizuj'])) {
    $id_produktu = $_POST['id'];
    $ilosc = $_POST['ilosc'];

    // Sprawdź, czy ilość jest większa niż zero przed aktualizacją
    if ($ilosc > 0) {
        $_SESSION['koszyk'][$id_produktu]['ilosc'] = $ilosc;
    } else {
        // Jeśli ilość wynosi 0 lub mniej, usuń produkt z koszyka
        unset($_SESSION['koszyk'][$id_produktu]);
    }

    // Przekieruj na koszyk po aktualizacji
    header("Location: koszyk.php");
    exit();
}
?>
