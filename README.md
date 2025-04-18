
# NoteShare Dokumentáció

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
- **Tanári Szerepkör**: A tanárok számára dedikált felület, amely lehetővé teszi számukra a jegyzetek kezelését.
- **Adminisztrátori Szerepkör**: Az adminisztrátorok hozzáadhatnak vagy eltávolíthatnak adminisztrátori jogosultságokat más felhasználóktól illetve bárki által közzétett jegyzetet törölhetnek.

---

## Telepítés

### Előfeltételek
- XAMPP vagy más helyi szerver PHP és MySQL támogatással.
- Egy webböngésző.

### Lépések
1. Klónozd le a projekt fájljait (pl. `git clone https://github.com/doomhyena/NoteShare.git`) a helyi szerver gyökérkönyvtárába (pl. `c:/xampp/htdocs/NoteShare`).
2. Importáld az adatbázist:
    - Nyisd meg a phpMyAdmin-t.
    - Hozz létre egy új adatbázist `noteshare` néven.
    - Importáld a `noteshare.sql` fájlt az `assets/sql/` mappából.
3. Konfiguráld az adatbázis kapcsolatot:
    - Nyisd meg a `cfg.php` fájlt.
    - Győződj meg róla, hogy az adatbázis hitelesítési adatok megfelelnek a helyi szerver beállításainak.
4. Indítsd el a helyi szervert, és navigálj a `http://localhost/NoteShare/` címre a böngésződben.

---

Kiegészítettem a README-ben az "Adatbázis Struktúra" szekciót az adatbázisban szereplő összes táblával, részletes mezőleírásokkal. Itt a frissített rész:

---

## Adatbázis Struktúra

### Táblák

1. **users**
   - `id` (INT, PK, AUTO_INCREMENT)
   - `lastname` (VARCHAR(100))
   - `firstname` (VARCHAR(100))
   - `username` (VARCHAR(50), UNIQUE)
   - `profile_picture` (VARCHAR(255))
   - `password` (VARCHAR(255))
   - `security_question` (VARCHAR(255))
   - `security_answer` (VARCHAR(255))
   - `admin` (TINYINT(1), alapértelmezetten 0)
   - `teacher` (TINYINT(1), alapértelmezetten 0)

2. **files**
   - `id` (INT, PK, AUTO_INCREMENT)
   - `uploaded_by` (INT, FK → users.id)
   - `name` (VARCHAR(255))
   - `file_name` (VARCHAR(255))
   - `description` (TEXT)
   - `file_path` (VARCHAR(255))
   - `tn_name` (VARCHAR(255))

3. **classes**
   - `id` (INT, PK, AUTO_INCREMENT)
   - `name` (VARCHAR(100), NOT NULL)
   - `created_at` (DATETIME, DEFAULT CURRENT_TIMESTAMP)
   - `created_by` (INT, FK → users.id)

4. **class_members**
   - `class_id` (INT, FK → classes.id)
   - `member_id` (INT, FK → users.id)
   - **Elsődleges kulcs**: (`class_id`, `member_id`)

5. **class_students**
   - `class_id` (INT, FK → classes.id)
   - `student_id` (INT, FK → users.id)
   - **Elsődleges kulcs**: (`class_id`, `student_id`)

6. **assignments**
   - `id` (INT, PK, AUTO_INCREMENT)
   - `class_id` (INT, FK → classes.id)
   - `title` (VARCHAR(255))
   - `grade` (VARCHAR(10))
   - `description` (TEXT)

7. **grades**
   - `id` (INT, PK, AUTO_INCREMENT)
   - `student_id` (INT, FK → users.id)
   - `grade` (VARCHAR(10))
   - `subject` (VARCHAR(255))
   - `entered_by` (INT, FK → users.id)

8. **schedules**
   - `id` (INT, PK, AUTO_INCREMENT)
   - `class_id` (INT, FK → classes.id)
   - `day_of_week` (ENUM)
   - `start_time` (TIME)
   - `end_time` (TIME)
   - `subject` (VARCHAR(255))
   - `teacher_id` (INT, FK → users.id)
   - `details` (TEXT)

9. **comments**
   - `id` (INT, PK, AUTO_INCREMENT)
   - `userid` (INT, FK → users.id)
   - `postid` (INT)
   - `text` (VARCHAR(1000))

10. **notifys**
    - `id` (INT, PK, AUTO_INCREMENT)
    - `fromid` (INT, FK → users.id)
    - `toid` (INT, FK → users.id)
    - `notifytype` (VARCHAR(100))
    - `readed` (TINYINT(1), DEFAULT 0)

11. **namedays**
    - `id` (INT)
    - `datum` (VARCHAR(5)) – például "04-18"
    - `nevek` (VARCHAR(255)) – névnaposok nevei

---

## Fájlstruktúra
```
NoteShare/
├── assets/
│   ├── css/
│   │   └── styles.css
│   ├── img/
│   │   └── favicon.ico
│   │   └── logo-1.png
│   │   └── logo-2.png
│   ├── php/
│   │   └── cfg.php
│   │   └── delete.php
│   │   └── download.php
│   │   └── findcurriculum.php
│   │   └── logout.php
│   ├── js/
│   │   └── script.js
│   ├── sql/
│   │   └── noteshare.sql
├── roles/
│   ├── admin/
│   │   ├── js/
│   │   │   └── script.js
│   │   ├── css/
│   │   │   └── styles.cs
│   │   └── admin.php
│   ├── students/
│   │   ├── js/
│   │   │   └── script.js
│   │   ├── css/
│   │   │   └── styles.cs
│   │   └── students.php
│   ├── teacher/
│   │   ├── js/
│   │   │   └── script.js
│   │   ├── css/
│   │   │   └── styles.cs
│   │   └── teacher.php
├── users/
├── forgotpass.php
├── index.php
├── login.php
├── notify.php
├── profile.php
├── README.md
├── reg.php
├── search.php
└── upload.php
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
2. **Hibakezelés**: Korlátozott hibaüzenetek a hibakereséshez.
3. **Meg nem jelenő pdf fájlok**: A *Forbidden You don't have permission to access this resource.* hibaüzenet jelenik meg a pdf fájlok esetében.

---

## Jövőbeli Fejlesztések
1. **Reszponzív Dizájn**: A felhasználói felület fejlesztése a jobb mobil kompatibilitás érdekében.
2. **Email Értesítések**: Email alapú jelszó visszaállítási funkció hozzáadása.
3. **Fájl Előnézetek**: A fájl előnézet támogatásának bővítése több fájltípusra.
4. **Szerepkör Kezelés**: Adminisztrátori szerepkörök bevezetése a jobb platformkezelés érdekében.
5. **Fejlettebb Biztonság**: CSRF tokenek és HTTPS támogatás implementálása.
6. **Tanári Funkciók Bővítése**: A tanárok számára további eszközök biztosítása, például jegyzetek értékelése vagy megjegyzések hozzáadása.
7. **Adminisztrátori Funkciók Fejlesztése**: Részletesebb statisztikák és felhasználói aktivitás követése az adminisztrátorok számára.

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
- **Tesztelés**: Funkcionális és biztonsági tesztek végrehajtása - *[Csontos Kincső & Szekeres Levente]*.
- **Projekt Menedzsment**: Feladatok koordinálása és határidők kezelése - *[Csontos Kincső]*.

---

## Licenc
Ez a projekt az MIT Licenc alatt érhető el.
