<?php
include('cfg.php');
class Kategoria {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function DodajKategorie($nazwa, $matka = 0) {
        if (empty($nazwa)) {
            return;
        }
        else{
            $stmt = $this->conn->prepare("INSERT INTO kategorie (nazwa, matka) VALUES (?, ?)");
            $stmt->bind_param("si", $nazwa, $matka);
            $stmt->execute();
        }

    }

    public function UsunKategorie($id) {
        $stmt = $this->conn->prepare("DELETE FROM kategorie WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $this->conn->query("ALTER TABLE kategorie AUTO_INCREMENT = 1");

    }

    public function EdytujKategorie($id, $nazwa, $matka = 0) {
        $stmt = $this->conn->prepare("UPDATE kategorie SET nazwa = ?, matka = ? WHERE id = ?");
        $stmt->bind_param("sii", $nazwa, $matka, $id);
        $stmt->execute();
    }

    public function PokazKategorie($matka_id = 0, $poziom = 0) {
        $stmt = $this->conn->prepare("SELECT * FROM kategorie WHERE matka = ?");
        $stmt->bind_param("i", $matka_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        while ($row = $result->fetch_assoc()) {
            echo str_repeat(' -> ', $poziom) . ' ' . $row['nazwa'] . ' (ID: ' . $row['id'] . ', Matka ID: ' . $row['matka'] . ')' . '<br>';
            $this->PokazKategorie($row['id'], $poziom + 1);
        }
    }

    public function ZarzadzajKategoriami() {
        if (isset($_POST['akcja'])) {
            switch ($_POST['akcja']) {
                case 'dodajKategorie':
                    $this->DodajKategorie($_POST['nazwa'], $_POST['matka']);
                    break;
                case 'usunKategorie':
                    $this->UsunKategorie($_POST['id']);
                    break;
                case 'edytujKategorie':
                    $this->EdytujKategorie($_POST['id'], $_POST['nazwa'], $_POST['matka']);
                    break;

            }
        }

        $this->PokazKategorie();
        
        echo '<form method="post" action="">
        <input type="hidden" name="akcja" value="dodajKategorie">
        <input type="text" name="nazwa" placeholder="Nazwa kategorii">
        <input type="number" name="matka" placeholder="ID kategorii nadrzędnej (opcjonalne)">
        <input type="submit" value="Dodaj kategorię">
    </form>';

    echo '<form method="post" action="">
        <input type="hidden" name="akcja" value="usunKategorie">
        <input type="number" name="id" placeholder="ID kategorii do usunięcia">
        <input type="submit" value="Usuń kategorię">
    </form>';

    echo '<form method="post" action="">
        <input type="hidden" name="akcja" value="edytujKategorie">
        <input type="number" name="id" placeholder="ID kategorii do edycji">
        <input type="text" name="nazwa" placeholder="Nowa nazwa kategorii">
        <input type="number" name="matka" placeholder="ID nowej kategorii nadrzędnej (opcjonalne)">
        <input type="submit" name="edytujKategorie" value="Edytuj kategorię">
    </form>';
    }
}


?>