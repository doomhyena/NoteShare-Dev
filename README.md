# NoteShare Readme

## Bevezetés
A **NoteShare** egy webalapú platform, amelyet diákok számára terveztek jegyzetek megosztására és letöltésére. Lehetővé teszi a felhasználók számára, hogy regisztráljanak, fájlokat töltsenek fel, kezeljék profiljukat, és letöltsék a megosztott anyagokat. A platform PHP és MySQL alapú.

---

## Telepítés

### Előfeltételek
- XAMPP vagy más helyi szerver PHP és MySQL támogatással.
- Egy webböngésző.

### Lépések
1. Klónozd le a projekt fájljait (pl. `git clone https://github.com/doomhyena/NoteShare-Dev.git`) a helyi szerver gyökérkönyvtárába (pl. `c:/xampp/htdocs/NoteShare-Dev`).
2. Importáld az adatbázist:
    - Nyisd meg a phpMyAdmin-t.
    - Importáld a `noteshare.sql` fájlt az `assets/sql/` mappából.
3. Konfiguráld az adatbázis kapcsolatot:
    - Nyisd meg a `cfg.php` fájlt.
    - Győződj meg róla, hogy az adatbázis hitelesítési adatok megfelelnek a helyi szerver beállításainak.
4. Indítsd el a helyi szervert, és navigálj a `http://localhost/NoteShare/` címre a böngésződben.

---


## Fájlstruktúra
```
NoteShare-Dev/
│   ├──/assets
│   │
│   ├── /css
│   │   └── styles.css          # A projekt stíluslapja
│   ├──/img
│   │   ├── favicon.ico         # Az alkalmazás faviconja
│   │   ├── logo-1.png          # Az első logó
│   │   └── logo-2.png          # A második logó
│   ├──/js
│   │   └── script.js           # A JavaScript fájl, amely a fő funkciókat tartalmazza
│   ├── /sql
│   │   └── noteshare.sql       # Az oldal adatbázisa
│   ├──/php
│   │   ├── accept_friend.php   # Barátok elfogadását kezelő fájl
│   │   ├── add_friend.php      # Barátok hozzáadását kezelő fájl
│   │   ├── cfg.php             # Az adatbázis kapcsolat beállításait tartalmazó fájl
│   │   ├── delete.php          # Fájlok törlését kezelő fájl
│   │   ├── download.php        # Fájlok letöltését kezelő fájl
│   │   ├── findanything.php    # Keresési funkciót megvalósító fájl
│   │   ├── loadmessages.php    # Üzenetek betöltését kezelő fájl
│   │   └── logout.php          # Kijelentkezést kezelő fájl
├── users/                      # Felhasználók tárhelyét tartalmazó mappa
├── forgotpass.php              # Jelszó visszaállítást kezelő fájl
├── index.php                   # Az oldal főoldala
├── LICENSE                     # Az oldal licensze
├── login.php                   # Bejelentkezést kezelő fájl
├── notify.php                  # Értesítéseket kezelő fájl
├── profile.php                 # Profilokat megjelenítő fájl
├── README.md                   # Az oldal dokumentációja markdown fájlként
├── reg.php                     # A regisztrációkat kezelő fájl
├── search.php                  # Keresést kezelő fájl
└── upload.php                  # Feltöltést kezelő fájl
```

---

## Használat

### Felhasználói Regisztráció
1. Navigálj a `reg.php` oldalra.
2. Töltsd ki a szükséges mezőket (vezetéknév, keresztnév, felhasználónév, jelszó).
3. Küldd el az űrlapot a fiók létrehozásához.

### Bejelentkezés
1. Navigálj a `login.php` oldalra.
2. Add meg a felhasználónevedet és jelszavadat.
3. Küldd el az űrlapot a bejelentkezéshez.

### Fájlok Feltöltése
1. Navigálj az `upload.php` oldalra.
2. Add meg a fájl nevét, és válaszd ki a feltöltendő fájlt.
3. Küldd el az űrlapot a fájl feltöltéséhez.

### Profilkezelés
1. Navigálj a `profile.php` oldalra.
2. Tekintsd meg feltöltött fájljaidat, és tölts fel profilképet.

### Fájlok Letöltése
1. Navigálj az `index.php` oldalra.
2. Böngészd az elérhető fájlok listáját.
3. Kattints a "Letöltés" linkre egy fájl letöltéséhez.

### Jelszó Visszaállítása
1. Navigálj a `forgotpass.php` oldalra.
2. Add meg a felhasználónevedet, és kövesd az utasításokat a jelszó visszaállításához.

### Barátok hozzáadása: A felhasználók barátokat adhatnak hozzá, és értesítéseket kapnak a barátok státuszáról.
1. Navigálj a `profile.php` vagy keress egy felhasználót a `search.php`-n.
2. Jelöld be a gomb segítségével.
3. Várd meg amíg visszaigazol.

### Üzenetküldés
1. Navigálj a `messages.php` oldalra.
2. Válaszd ki, hogy kinek szeretnél üzenetet küldeni.
3. Küldd el az üzenetedet.

---

## Biztonsági Szempontok
- **Jelszó Hash-elés**: A jelszavak `password_hash()` segítségével kerülnek tárolásra a biztonság érdekében.
- **Fájl Feltöltések**: A fájltípusok ellenőrzése és korlátozása a rosszindulatú feltöltések elkerülése érdekében.
- **Munkamenet Kezelés**: Sütik használata a munkamenet kezeléséhez, biztonságos süti gyakorlatokkal.

---

## Ismert Hibák
**Hibakezelés**: Korlátozott hibaüzenetek a hibakereséshez.

---

## Felhasznált tervezői környezetek és program nyelvek
- **Backend**: PHP (8.2+), jQuery
- **Adatbázis**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript 
- **Fejlesztői környezet**: XAMPP (PHP és MySQL támogatással)
- **Egyéb eszközök**: phpMyAdmin, Git

---

## Ki mit készített?
- **Backend Fejlesztés**: Backend logika, adatbázis kapcsolat - *[Csontos Kincső]*.
- **Frontend Fejlesztés**: Felhasználói felület tervezése és reszponzív dizájn - *[Szekeres Levente]*.
- **Adatbázis Tervezés**: Adatbázis struktúra és SQL szkriptek - *[Csontos Kincső]*.
- **Dokumentáció**: Projekt dokumentáció elkészítése - *[Csontos Kincső]*.
- **Tesztelés**: Funkcionális tesztek végrehajtása - *[Csontos Kincső & Szekeres Levente]*.
- **Projekt Menedzsment**: Feladatok koordinálása és határidők kezelése - *[Csontos Kincső]*.

---

## Licenc
Ez a projekt az MIT Licenc alatt érhető el.
