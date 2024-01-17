<?php
global $conn;
include('cfg.php');

class Produkt {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function DodajProdukt($tytul, $opis, $cena_netto, $podatek_vat, $ilosc_sztuk, $status_dostepnosci, $kategoria, $gabaryt, $zdjecie) {
        if (empty($tytul)) {
            return;
        }

        if (isset($_FILES['zdjecie']) && $_FILES['zdjecie']['error'] === UPLOAD_ERR_OK) {
            $zdjecieBin = file_get_contents($_FILES['zdjecie']['tmp_name']);
            $stmt = $this->conn->prepare("INSERT INTO produkty (tytul, opis, cena_netto, podatek_vat, ilosc_sztuk, status_dostepnosci, kategoria, gabaryt, zdjecie) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssddisiss", $tytul, $opis, $cena_netto, $podatek_vat, $ilosc_sztuk, $status_dostepnosci, $kategoria, $gabaryt, $zdjecieBin);
            $stmt->execute();
        }
    }

    public function UsunProdukt($id) {
        $stmt = $this->conn->prepare("DELETE FROM produkty WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $this->conn->query("ALTER TABLE produkty AUTO_INCREMENT = 1");
    }

    public function EdytujProdukt($id, $tytul, $opis, $cena_netto, $podatek_vat, $ilosc_sztuk, $status_dostepnosci, $kategoria, $gabaryt, $zdjecie) {
        if (isset($_FILES['zdjecie']) && $_FILES['zdjecie']['error'] === UPLOAD_ERR_OK) {
            $zdjecieBin = file_get_contents($_FILES['zdjecie']['tmp_name']);
        }
        $stmt = $this->conn->prepare("UPDATE produkty SET tytul = ?, opis = ?, cena_netto = ?, podatek_vat = ?, ilosc_sztuk = ?, status_dostepnosci = ?, kategoria = ?, gabaryt = ?, zdjecie = ? WHERE id = ?");
        $stmt->bind_param("ssddisissi", $tytul, $opis, $cena_netto, $podatek_vat, $ilosc_sztuk, $status_dostepnosci, $kategoria, $gabaryt, $zdjecieBin, $id);
        $stmt->execute();
    }

    public function PokazProdukty() {
        $result = $this->conn->query("SELECT * FROM produkty");

        while ($row = $result->fetch_assoc()) {
            echo "<p>ID: " . $row['id'] . ", Tytuł: " . $row['tytul'] . ", Opis: " . $row['opis'] . ", Cena netto: " . $row['cena_netto'] . ", Podatek VAT: " . $row['podatek_vat'] . ", Ilość sztuk: " . $row['ilosc_sztuk'] . ", Status dostępności: " . $row['status_dostepnosci'] . ", Kategoria: " . $row['kategoria'] . ", Gabaryt: " . $row['gabaryt'] . "</p>";
        }
    }

    public function ZarzadzajProduktami() {
        if (isset($_POST['akcja'])) {
            switch ($_POST['akcja']) {
                case 'dodajProdukt':
                    $this->DodajProdukt($_POST['tytul'], $_POST['opis'], $_POST['cena_netto'], $_POST['podatek_vat'], $_POST['ilosc_sztuk'], $_POST['status_dostepnosci'], $_POST['kategoria'], $_POST['gabaryt'], $_FILES['zdjecie']);
                    break;
                case 'usunProdukt':
                    $this->UsunProdukt($_POST['id']);
                    break;
                case 'edytujProdukt':
                    $this->EdytujProdukt($_POST['id'], $_POST['tytul'], $_POST['opis'], $_POST['cena_netto'], $_POST['podatek_vat'], $_POST['ilosc_sztuk'], $_POST['status_dostepnosci'], $_POST['kategoria'], $_POST['gabaryt'], $_FILES['zdjecie']);
                    break;
            }
        }

        $this->PokazProdukty();

        echo '<form method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="akcja" value="dodajProdukt">
    <input type="text" name="tytul" placeholder="Tytuł produktu">
    <textarea name="opis" placeholder="Opis produktu"></textarea>
    <input type="number" step="0.01" name="cena_netto" placeholder="Cena netto">
    <input type="number" step="0.01" name="podatek_vat" placeholder="Podatek VAT">
    <input type="number" name="ilosc_sztuk" placeholder="Ilość sztuk">
    <input type="number" name="status_dostepnosci" placeholder="Status dostępności">
    <input type="number" name="kategoria" placeholder="Kategoria">
    <input type="text" name="gabaryt" placeholder="Gabaryt">
    <input type="file" name="zdjecie" placeholder="Zdjęcie">
    <input type="submit" name="dodajProdukt" value="Dodaj produkt">
</form>';

        echo '<form method="post" action="">
    <input type="hidden" name="akcja" value="usunProdukt">
    <input type="number" name="id" placeholder="ID produktu do usunięcia">
    <input type="submit" value="Usuń produkt">
</form>';

        echo '<form method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="akcja" value="edytujProdukt">
    <input type="number" name="id" placeholder="ID produktu do edycji">
    <input type="text" name="tytul" placeholder="Tytuł produktu">
    <textarea name="opis" placeholder="Opis produktu"></textarea>
    <input type="number" step="0.01" name="cena_netto" placeholder="Cena netto">
    <input type="number" step="0.01" name="podatek_vat" placeholder="Podatek VAT">
    <input type="number" name="ilosc_sztuk" placeholder="Ilość sztuk">
    <input type="number" name="status_dostepnosci" placeholder="Status dostępności">
    <input type="number" name="kategoria" placeholder="Kategoria">
    <input type="text" name="gabaryt" placeholder="Gabaryt">
    <input type="file" name="zdjecie" placeholder="Zdjęcie">
    <input type="submit" name="edytujProdukt" value="Edytuj produkt">
</form>';
    }
}
?>
