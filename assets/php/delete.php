<?php

    require "db.php"; // Adatbázis kapcsolat betöltése

    // Lekérdezi a felhasználót a cookie alapján
    $sql = "SELECT * FROM users WHERE id='" . $_COOKIE['id'] . "'";
    $found_user = $conn->query($sql);
    $user = $found_user->fetch_assoc();
    
    // Ellenőrzi, hogy van-e 'id' paraméter GET-ben
    if (isset($_GET['id'])) {
        $file_id = $_GET['id']; // Fájl azonosító lekérése
        $sql = "SELECT * FROM files WHERE id='$file_id'";
        $result = $conn->query($sql); // Fájl lekérdezése az adatbázisból
    
        if ($result->num_rows > 0) { // Ha létezik ilyen fájl

            $file = $result->fetch_assoc(); // Fájl adatok lekérése
            $file_name = $file['file_name']; // Fájlnév lekérése
            $folder = getcwd(); // Aktuális könyvtár lekérése
            $path = $folder . "\\assets\\users\\" . $user['username'] . "\\" . $file_name; // Fájl elérési útjának összeállítása
            $sql = "DELETE FROM files WHERE id='$file_id'";
            $conn->query($sql); // Fájl törlése az adatbázisból
    
            if (file_exists($path)) { // Ha létezik a fájl a szerveren

                unlink($path); // Fájl törlése
                unlink($tn_path); // (NEM DEFINIÁLT) Bélyegkép törlése
                header('Location: myprofile.php'); // Átirányítás a profil oldalra
                
            } else {
                echo "A fájl nem található."; // Hibaüzenet, ha nincs meg a fájl
            }
        } else {
            echo "Nincs fájl kiválasztva."; // Hibaüzenet, ha nincs ilyen fájl
        }
    }
?>