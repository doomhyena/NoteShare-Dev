<?php

    // Betölti az adatbázis kapcsolatot tartalmazó fájlt
    require "db.php";

    // Lekéri a letölteni kívánt fájl azonosítóját a GET paraméterből, és egész számmá alakítja
    $file_id = intval($_GET['id']);
    // Lekérdezi az adatbázisból a fájl adatait az azonosító alapján
    $sql = "SELECT * FROM files WHERE id=$file_id";
    $file_result = $conn->query($sql);

    // Ellenőrzi, hogy létezik-e ilyen fájl
    if ($file_result->num_rows > 0) {
        // Lekéri a fájl adatait asszociatív tömbként
        $file = $file_result->fetch_assoc();
        
        // Lekérdezi a fájlt feltöltő felhasználó adatait az adatbázisból
        $sql = "SELECT * FROM users WHERE id=" . intval($file['uploaded_by']);
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
        // Összeállítja a fájl elérési útját a szerveren
        $folder = dirname(getcwd(), 2); 
        $path = $folder . "/users/" . $user['username'] . "/" . $file['file_name'];
        
        // Ellenőrzi, hogy a fájl létezik-e a megadott útvonalon
        if (file_exists($path)) {

            // Beállítja a szükséges HTTP fejléceket a fájl letöltéséhez
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            // Kiírja a fájl tartalmát a kimenetre (letöltés indítása)
            readfile($path);
            
        } else {
            // Hibaüzenet, ha a fájl nem található
            echo "A fájl nem található: $path";
        }
    } else {
        // Hibaüzenet, ha nincs kiválasztott fájl
        echo "Nincs fájl kiválasztva.";
    }
?>