# „Schola Europa Akadémia” Technikum, Gimnázium és Alapfokú Művészeti Iskola a  Magyarországi Metodista Egyház fenntartásában

**SZOFTVERFEJLESZTŐ ÉS -TESZTELŐ**
5 0613 12 03

Dokumentáció
**2025**

Készítette:
Csontos Kincső 
Szekeres Levente

__2025__

# NoteShare - Online Jegyzetmegosztós Platform Dokumentáció

1. [Bevezetés](#1-bevezetés)
   - 1.1. [A Projekt Célja](#11-a-projekt-célja)
   - 1.2. [Főbb Funkciók](#12-főbb-funkciók)
   - 1.3. [Technológiai Stack](#13-technológiai-stack)

2. [Rendszerarchitektúra](#2-rendszerarchitektúra)
   - 2.1. [Magas Szintű Architektúra](#21-magas-szintű-architektúra)
   - 2.2. [Komponensek](#22-komponensek)
   - 2.3. [Adatbázis Séma](#23-adatbázis-séma)

3. [Frontend Architektúra](#3-frontend-architektúra)
   - 3.1. [UI/UX Design](#31-uiux-design)

4. [Backend Architektúra](#4-backend-architektúra)
   - 4.1. [Szolgáltatások](#41-szolgáltatások)
   - 4.2. [Adatbázis Kapcsolat](#42-adatbázis-kapcsolat)
   - 4.3. [Fájlkezelés](#43-fájlkezelés)

5. [Deployment](#5-deployment)
   - 4.1. [Környezetek](#51-környezetek)
   - 4.2. [Fejlesztői környezet](#52-fejlesztői-környezet-development)
   - 4.3. [Kód commit és push](#53-kód-commit-és-push)
   - 4.4. [Code review](#54-pull-request-és-code-review)
   - 4.5. [Hibaelhárítás](#55-hibaelhárítás)

6. [Felhasználói Dokumentáció](#6-felhasználói-dokumentáció)
   - 6.1. [Telepítési Útmutató](#61-telepítési-útmutató)
   - 6.2. [Használat](#62-használat)
   - 6.3. [Weben Belüli Navigáicó](#63-weben-belüli-navigáció)
   - 6.4. [Biztonsági Tippek](#64-biztonsági-tippek)

7. [Fejlesztői Dokumentáció](#7-fejlesztői-dokumentáció)
    - 7.1. [Fejlesztői Környezet Beállítása](#71-fejlesztői-környezet-beállítása)
    - 7.2. [Kódolási Konvenciók](#72-kódolási-konvenciók)
    - 7.3. [Verziókezelési Stratégia](#73-verziókezelési-stratégia)
    - 7.4. [FájlStruktúra](#74-fájlstruktúra)

8. [Jövőbeli Tervek](#8-jövőbeli-tervek)
    - 8.1. [Felhasználói fiók bővítések](#81-felhasználói-fiók-bővítések)
    - 8.2. [Nyelvi lokalizáció](#82-nyelvi-lokalizáció)
    - 8.3. [Kétlépcsős hitelesítés](#83-kétlépcsős-hiteleítés)
    - 8.4. [AI-alapú keresés és javaslatok](#84-ai-alapú-keresés-és-javaslatok)
    - 8.5. [Gamifikáció](#85-gamifikáció)

9. [Az Oldalak Galériája](#9-az-oldalak-galériája)

10. [Ki mit készített?](#10-ki-mit-készített?)

11. [Licensz](#11-licensz) 

## 1. Bevezetés

### 1.1. A Projekt Célja

A **NoteShare** egy modern, közösségi alapú, oktatássegítő platform, amely lehetővé teszi a diákok számára, hogy egyszerűen és biztonságosan megosszák egymással jegyzeteiket, segédanyagaikat és tanulást támogató dokumentumaikat. A projekt célja, hogy:

* **Gyors és kényelmes fájlmegosztást biztosítson tanulóknak**

  - A felhasználók könnyedén feltölthetnek, kereshetnek és letölthetnek jegyzeteket
  - A platform reszponzív kialakítása biztosítja a mobilbarát használatot
  - Az egyszerű kezelőfelület csökkenti az informatikai tudás iránti igényt

* **Rendszerezett és kereshető tananyagbázist hozzon létre**

  - Tantárgyak, évfolyamok és dokumentumtípusok szerint kategorizál
  - Kulcsszavas keresés és szűrés segíti a gyors anyagkeresést
  - Előnézeti kép vagy rövid leírás segít a tartalom gyors azonosításában

* **Támogassa a közösségi tanulást**

  - A felhasználók értékelhetik, kommentelhetik a jegyzeteket
  - A rendszer kiemeli a legnépszerűbb vagy legjobbra értékelt anyagokat
  - Gamifikációs elemek motiválják a közreműködést (pl. pontok, rangok)

* **Biztonságos és megbízható szolgáltatást nyújtson**

  - Jogosultságkezelés szabályozza a feltöltési és megtekintési lehetőségeket
  - A rendszer automatikus vírusellenőrzést és fájltípusszűrést alkalmaz
  - A felhasználói adatok és fájlok titkosítva, biztonságos környezetben tárolódnak

* **Skálázható megoldást biztosítson iskolai vagy egyetemi szintű használatra**

  - Támogatja több ezer felhasználó és fájl egyidejű kezelését
  - API-n keresztül bővíthető mobilalkalmazás vagy más rendszerek irányába
  - A struktúra modulárisan bővíthető új funkciókkal

---

### 1.2. Főbb Funkciók

A NoteShare rendszer az alábbi kulcsfunkciókat biztosítja:

### Fájlfeltöltés és -kezelés

- Jegyzetek és segédanyagok feltöltése PDF, DOCX, PPT és képfájl formátumban
- Automatikus kategorizálás évfolyam, tantárgy és dokumentumtípus szerint
- Előnézeti kép generálása (PDF első oldal, képek)

### Felhasználói felület

- Regisztráció és bejelentkezés (alap és OAuth)
- Egyéni irányítópult a feltöltések, letöltések, értékelések követésére
- Mobilbarát és reszponzív dizájn

### Keresés és közösségi funkciók

- Kulcsszavas kereső és szűrő (tantárgy, évfolyam, értékelés alapján)
- Kommentelés, csillagozás és „hasznos” gomb
- Legnépszerűbb jegyzetek és új feltöltések kiemelése

### Adminisztráció és jogosultságok

- Admin felület a tartalmak, felhasználók és kategóriák kezeléséhez
- Feltöltések jelentése és moderálása
- Letöltési statisztikák, fájlhasználat követése

### Biztonság és adatvédelem

- Fájltípus- és méretkorlát, vírusellenőrzés
- Titkosított jelszótárolás és biztonságos session-kezelés
- GDPR-kompatibilis adatkezelés

### 1.3. Technológiai Stack

A NoteShare fejlesztése során a következő technológiákat és eszközöket használtuk:

### Frontend
- **HTML5, CSS3, JavaScript**: Az alapvető webes technológiák a felhasználói felület kialakításához.
- **Bootstrap**: Reszponzív és mobilbarát dizájn gyors fejlesztéséhez.
- **jQuery**: Egyszerű DOM-manipulációk és AJAX-hívások kezelésére.

### Backend
- **PHP (8.2+)**: A szerveroldali logika és API-k implementálásához.


### Adatbázis
- **MySQL**: Relációs adatbázis-kezelő a felhasználói adatok, fájlok és egyéb információk tárolására.
- **phpMyAdmin**: Az adatbázis adminisztrációjához.

### Verziókezelés
- **Git**: Verziókövetés és csapatmunka támogatása.
- **GitHub**: Távoli repository a kód tárolására és megosztására.

### Egyéb eszközök
- **XAMPP**: Lokális fejlesztői környezet (Apache, MySQL, PHP).
- **Visual Studio Code**: Kódszerkesztő a fejlesztéshez.
- **XAMPP (PHP és MySQL támogatással)**:

## 2. Rendszerarchitektúra

### 2.1. Magas Szintű Architektúra
A NoteShare egy háromrétegű architektúrát követ:
1. **Prezentációs réteg**: A felhasználói felület, amely a frontend technológiákra épül.
2. **Alkalmazásréteg**: A backend logika, amely PHP segítségével valósul meg.
3. **Adatbázis réteg**: A MySQL adatbázis, amely az összes adatot tárolja.

### 2.2. Komponensek
- **Frontend**: A felhasználói interakciók kezelése és az adatok megjelenítése.
- **Backend**: Az logika és az adatbázis műveletek végrehajtása.
- **Adatbázis**: A felhasználói adatok, fájlok és metaadatok tárolása.

### 2.3. Adatbázis Séma

#### Táblák

```bash

1. users
   - `id` (INT, PK, AUTO_INCREMENT)
   - `lastname` (VARCHAR(100))
   - `firstname` (VARCHAR(100))
   - `username` (VARCHAR(50), UNIQUE)
   - `email` (VARCHAR(50), UNIQUE)
   - `profile_picture` (VARCHAR(255))
   - `password` (VARCHAR(255))
   - `security_question` (VARCHAR(255))
   - `security_answer` (VARCHAR(255))
   - `registration_date` DATETIME

2. files
   - `id` (INT, PK, AUTO_INCREMENT)
   - `uploaded_by` (INT, FK → users.id)
   - `name` (VARCHAR(255))
   - `file_name` (VARCHAR(255))
   - `description` (TEXT)
   - `file_path` (VARCHAR(255))
   - `tn_name` (VARCHAR(255))

3. comments
   - `id` (INT, PK, AUTO_INCREMENT)
   - `userid` (INT, FK → users.id)
   - `postid` (INT)
   - `text` (VARCHAR(1000))

4. notifys
    - `id` (INT, PK, AUTO_INCREMENT)
    - `fromid` (INT, FK → users.id)
    - `toid` (INT, FK → users.id)
    - `notifytype` (VARCHAR(100))
    - `readed` (TINYINT(1), DEFAULT 0)

5. namedays
    - `id` (INT, PK, AUTO_INCREMENT)
    - `datum` (VARCHAR(5))
    - `nevek` (VARCHAR(255))

6. messages
    - `id` (INT, PK, AUTO_INCREMENT)
    - `fromid` (INT, FK → users.id)
    - `toid` (INT, FK → users.id)
    - `content` text NOT NULL,
    - `sent_at` date NOT NULL DEFAULT current_timestamp()

```


## 3. Frontend Architektúra

### 3.1. UI/UX Design
A NoteShare felhasználói felülete egyszerű és intuitív, a következő szempontokat figyelembe véve:
- **Reszponzív dizájn**: A platform minden eszközön jól használható.
- **Egyszerű navigáció**: Könnyen elérhető funkciók és tiszta menürendszer.
- **Konzisztens stílus**: Azonos színpaletta és tipográfia az egész alkalmazásban.

## 4. Backend Architektúra

### 4.1. Szolgáltatások
- Felhasználói regisztráció.
- Fájlok feltöltése, letöltése és kezelése.
- Kommentek és értékelések kezelése.

### 4.2. Adatbázis Kapcsolat
A PHP mysqli-t használjuk az adatbázis műveletek végrehajtására.

### 4.3. Fájlkezelés
A feltöltött fájlokat a szerveren tároljuk, és a fájlokhoz tartozó metaadatokat az adatbázisban rögzítjük.

## 5. Deployment

### 5.1. Környezetek
- **Fejlesztői környezet**: Lokális XAMPP szerver.
- **Éles környezet**: Apache szerver MySQL adatbázissal.

### 5.2. Fejlesztői környezet
A fejlesztéshez szükséges összes függőség telepítése Composer és npm segítségével történik.

### 5.3. Kód commit és push
A kódot Git segítségével kezeljük, és minden változtatást a GitHub repository-ba push-olunk.

### 5.4. Code review
Minden új funkciót pull request formájában integrálunk, amelyet code review előz meg.

### 5.5. Hibaelhárítás
A hibák nyomon követésére és kezelésére a GitHub Issues funkcióját használjuk.


### 6. Felhasználói Dokumentáció

#### 6.1. Telepítési Útmutató

##### Előfeltételek
    - XAMPP vagy más helyi szerver PHP és MySQL támogatással.
    - Egy webböngésző.

```bash
1. Klónozd le a projekt fájljait (pl. `git clone https://github.com/doomhyena/NoteShare-Dev.git`) a helyi szerver gyökérkönyvtárába (pl. `c:/xampp/htdocs/NoteShare-Dev`).
2. Importáld az adatbázist:
- Nyisd meg a phpMyAdmin-t.
- Importáld a `noteshare.sql` fájlt az `assets/sql/` mappából.
3. Konfiguráld az adatbázis kapcsolatot:
- Nyisd meg a `cfg.php` fájlt.
- Győződj meg róla, hogy az adatbázis hitelesítési adatok megfelelnek a helyi szerver beállításainak.
4. Indítsd el a helyi szervert, és navigálj a `http://localhost/NoteShare/` címre a böngésződben.
```

#### 6.2. Használat 

1. Felhasználói Regisztráció
    1. Navigálj a `reg.php` oldalra.
    2. Töltsd ki a szükséges mezőket (vezetéknév, keresztnév, felhasználónév, jelszó).
    3. Küldd el az űrlapot a fiók létrehozásához.

2. Bejelentkezés
    1. Navigálj a `login.php` oldalra.
    2. Add meg a felhasználónevedet és jelszavadat.
    3. Küldd el az űrlapot a bejelentkezéshez.

3. Fájlok Feltöltése
    1. Navigálj az `upload.php` oldalra.
    2. Add meg a fájl nevét, és válaszd ki a feltöltendő fájlt.
    3. Küldd el az űrlapot a fájl feltöltéséhez.

4. Profilkezelés
    1. Navigálj a `profile.php` oldalra.
    2. Tekintsd meg feltöltött fájljaidat, és tölts fel profilképet.

4. Fájlok Letöltése
    1. Navigálj az `index.php` oldalra.
    2. Böngészd az elérhető fájlok listáját.
    3. Kattints a "Letöltés" linkre egy fájl letöltéséhez.

5. Jelszó Visszaállítása
    1. Navigálj a `forgotpass.php` oldalra.
    2. Add meg a felhasználónevedet, és kövesd az utasításokat a jelszó visszaállításához.

6. Barátok hozzáadása: A felhasználók barátokat adhatnak hozzá, és értesítéseket kapnak a barátok státuszáról.
    1. Navigálj a `profile.php` vagy keress egy felhasználót a `search.php`-n.
    2. Jelöld be a gomb segítségével.
    3. Várd meg amíg visszaigazol.

7. Üzenetküldés
    1. Navigálj a `messages.php` oldalra.
    2. Válaszd ki, hogy kinek szeretnél üzenetet küldeni.
    3. Küldd el az üzenetedet.

#### 6.3. Weben belüli navigáció

#### 6.4. Biztonsági Tippek

1. **Fiók biztonsága:**
   - Használjon erős jelszót
   - Engedélyezze a kétfaktoros azonosítást
   - Ne ossza meg a bejelentkezési adatait

2. **Adatok biztonsága:**
   - Rendszeresen készítsen biztonsági másolatot
   - Ne küldjön bizalmas adatokat emailben
   - Használjon biztonságos kapcsolatot

3. **Rendszer biztonsága:**
   - Tartsa naprakészen a szoftvert
   - Használjon vírusirtót
   - Kerülje a nyilvános hálózatokat

4. **Jogosultságok kezelése:**
   - Csak a szükséges jogosultságokat adja meg
   - Rendszeresen ellenőrizze a jogosultságokat
   - Azonnal vonja vissza a nem használt jogosultságokat

### 7. Fejlesztői Dokumentáció

### 7.1. Fejlesztői Környezet Beállítása
```bash
1. Klónozd le a projekt fájljait (pl. `git clone https://github.com/doomhyena/NoteShare-Dev.git`) a helyi szerver gyökérkönyvtárába (pl. `c:/xampp/htdocs/NoteShare-Dev`).
2. Importáld az adatbázist:
- Nyisd meg a phpMyAdmin-t.
- Importáld a `noteshare.sql` fájlt az `assets/sql/` mappából.
3. Konfiguráld az adatbázis kapcsolatot:
- Nyisd meg a `cfg.php` fájlt.
- Győződj meg róla, hogy az adatbázis hitelesítési adatok megfelelnek a helyi szerver beállításainak.
4. Indítsd el a helyi szervert, és navigálj a `http://localhost/NoteShare/` címre a böngésződben.
```

### 7.2. Kódolási Konvenciók
- **PHP**: PSR-12 szabvány.
- **JavaScript**: ES6+ szabvány.

### 7.3. Verziókezelési Stratégia
- **Main branch**: Stabil, éles verzió.
- **Feature branch-ek**: Új funkciók fejlesztésére.

### 7.4 FájlStruktúra

```bash

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
│   │   ├── db.php              # Az adatbázis kapcsolat beállításait tartalmazó fájl
│   │   ├── delete.php          # Fájlok törlését kezelő fájl
│   │   ├── download.php        # Fájlok letöltését kezelő fájl
│   │   ├── findanything.php    # Keresési funkciót megvalósító fájl
│   │   ├── footer.php          # A footer-t megjelenítő fájl
│   │   ├── loadmessages.php    # Üzenetek betöltését kezelő fájl
│   │   ├── logout.php          # Kijelentkezést kezelő fájl
│   │   └── navbar.php          # navbar-t megjelenítő fájé
├── users/                      # Felhasználók tárhelyét tartalmazó mappa
├── Év végi feladat.pdf         # A feladatot leíró dokumentum
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

## 8. Jövőbeli Tervek

### 8.1. Felhasználói fiók bővítések
- Profil testreszabási lehetőségek.

### 8.2. Nyelvi lokalizáció
- Többnyelvű támogatás (pl. angol, magyar).

### 8.3. Kétlépcsős hitelesítés
- SMS vagy e-mail alapú hitelesítés.

### 8.4. AI-alapú keresés és javaslatok
- Gépi tanulás az anyagok ajánlására.

### 8.5. Gamifikáció
- Pontok és jelvények a felhasználói aktivitás ösztönzésére.

## 9. Az oldalak Galériája

## 10. Ki mit készített?

### Csontos Kincső

- **Backend Fejlesztés**: Backend logika, adatbázis kapcsolat.
- **Adatbázis Tervezés**: Adatbázis struktúra és SQL szkriptek.
- **Dokumentáció**: Projekt dokumentáció elkészítése.
- **Tesztelés**: Funkcionális tesztek végrehajtása.
- **Projekt Menedzsment**: Feladatok koordinálása és határidők kezelése.

### Szekeres Levente

- **Frontend Fejlesztés**: Felhasználói felület tervezése és reszponzív dizájn
- **Tesztelés**: Funkcionális tesztek végrehajtása.

## 11. Licensz
Ez a projekt az MIT Licensz alatt érhető el.