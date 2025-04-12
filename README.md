# NoteShare Dokumentáció

## Tartalomjegyzék
1. [Bevezetés](#bevezetés)
2. [Funkciók](#funkciók)
3. [Telepítés](#telepítés)
4. [Adatbázis Struktúra](#adatbázis-struktúra)
5. [Fájlstruktúra](#fájlstruktúra)
6. [Használat](#használat)
7. [Biztonsági Szempontok](#biztonsági-szempontok)
8. [Ismert Hibák](#ismert-hibák)
9. [Jövőbeli Fejlesztések](#jövőbeli-fejlesztések)
10. [Felhasznált tervezői környezetek és program nyelvek](#felhasznált-tervezői-környezetek-és-program-nyelvek)
11. [Ki mit készített?](#Ki-mit-készített)

---

## Bevezetés
A **NoteShare** egy webalapú platform, amelyet diákok számára terveztek jegyzetek megosztására és letöltésére. Lehetővé teszi a felhasználók számára, hogy regisztráljanak, fájlokat töltsenek fel, kezeljék profiljukat, és letöltsék a megosztott anyagokat. A platform PHP és MySQL alapú, egyszerű és intuitív felhasználói felülettel.

---

## Funkciók
- **Felhasználói Regisztráció és Bejelentkezés**: A felhasználók biztonságosan hozhatnak létre fiókokat és jelentkezhetnek be.
- **Fájl Feltöltés és Letöltés**: A felhasználók jegyzeteket tölthetnek fel és tölthetnek le mások által megosztott fájlokat.
- **Profilkezelés**: A felhasználók frissíthetik profilképeiket és megtekinthetik feltöltött fájljaikat.
- **Elfelejtett Jelszó**: A felhasználók visszaállíthatják elfelejtett jelszavaikat.
- **Fájl Törlés**: A felhasználók törölhetik feltöltött fájljaikat.
- **Reszponzív Dizájn**: A platform különböző eszközökön is működik.

---

## Telepítés

### Előfeltételek
- XAMPP vagy más helyi szerver PHP és MySQL támogatással.
- Egy webböngésző.

### Lépések
1. Klónozd vagy töltsd le a projekt fájljait a helyi szerver gyökérkönyvtárába (pl. `c:/xampp/htdocs/NoteShare`).
2. Importáld az adatbázist:
    - Nyisd meg a phpMyAdmin-t.
    - Hozz létre egy új adatbázist `noteshare` néven.
    - Importáld a `noteshare.sql` fájlt az `assets/sql/` mappából.
3. Konfiguráld az adatbázis kapcsolatot:
    - Nyisd meg a `cfg.php` fájlt.
    - Győződj meg róla, hogy az adatbázis hitelesítési adatok megfelelnek a helyi szerver beállításainak.
4. Indítsd el a helyi szervert, és navigálj a `http://localhost/NoteShare/` címre a böngésződben.

---

## Adatbázis Struktúra

### Táblák
1. **users**
    - `id` (int, elsődleges kulcs, automatikus növekedés)
    - `lastname` (varchar)
    - `firstname` (varchar)
    - `username` (varchar, egyedi)
    - `profile_picture` (varchar)
    - `password` (varchar)

2. **files**
    - `id` (int, elsődleges kulcs, automatikus növekedés)
    - `userid` (int, idegen kulcs, hivatkozás a `users.id`-re)
    - `name` (varchar)
    - `file_name` (varchar)
    - `tn_name` (varchar)

---

## Fájlstruktúra
```
NoteShare/
├── assets/
│   ├── css/
│   │   └── styles.css
│   ├── js/
│   │   └── script.js
│   ├── sql/
│   │   └── noteshare.sql
│   └── users/
├── index.php
├── myprofile.php
├── upload.php
├── reg.php
├── login.php
├── logout.php
├── forgotpass.php
├── download.php
├── delete.php
└── cfg.php
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
1. Navigálj a `myprofile.php` oldalra.
2. Tekintsd meg feltöltött fájljaidat, és tölts fel profilképet.

### Fájlok Letöltése
1. Navigálj az `index.php` oldalra.
2. Böngészd az elérhető fájlok listáját.
3. Kattints a "Letöltés" linkre egy fájl letöltéséhez.

### Jelszó Visszaállítása
1. Navigálj a `forgotpass.php` oldalra.
2. Add meg a felhasználónevedet, és kövesd az utasításokat a jelszó visszaállításához.

---

## Biztonsági Szempontok
- **Jelszó Hash-elés**: A jelszavak `password_hash()` segítségével kerülnek tárolásra a biztonság érdekében.
- **Fájl Feltöltések**: A fájltípusok ellenőrzése és korlátozása a rosszindulatú feltöltések elkerülése érdekében.
- **Munkamenet Kezelés**: Sütik használata a munkamenet kezeléséhez, biztonságos süti gyakorlatokkal.

---

## Ismert Hibák
1. **Fájlútvonal Kezelés**: A hardkódolt fájlútvonalak problémákat okozhatnak nem Windows rendszereken.
3. **Hibakezelés**: Korlátozott hibaüzenetek a hibakereséshez.
4. **Meg nem jelenő pdf fájlok**: A *Forbidden You don't have permission to access this resource.* hibaüzenet jelenik meg a pdf fájl

---

## Jövőbeli Fejlesztések
1. **Reszponzív Dizájn**: A felhasználói felület fejlesztése a jobb mobil kompatibilitás érdekében.
2. **Email Értesítések**: Email alapú jelszó visszaállítási funkció hozzáadása.
3. **Fájl Előnézetek**: A fájl előnézet támogatásának bővítése több fájltípusra.
4. **Szerepkör Kezelés**: Adminisztrátori szerepkörök bevezetése a jobb platformkezelés érdekében.
5. **Fejlettebb Biztonság**: CSRF tokenek és HTTPS támogatás implementálása.

---

## Felhasznált tervezői környezetek és program nyelvek
- **Backend**: PHP (8.2+)
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
- **Tesztelés**: Funkcionális és biztonsági tesztek végrehajtása - *[Csontos Kincső] & Szekeres Levente]*.
- **Projekt Menedzsment**: Feladatok koordinálása és határidők kezelése - *[Csontos Kincső]*.

---

## Licenc
Ez a projekt az MIT Licenc alatt érhető el.
