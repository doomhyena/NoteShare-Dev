<div align="center">
<h1> „Schola Europa Akadémia” Technikum, Gimnázium és Alapfokú Művészeti Iskola a  Magyarországi Metodista Egyház fenntartásában </h1>

<br> ![Schola Europa Akadémia logó](img/scholalogo.png)<br>

**SZOFTVERFEJLESZTŐ ÉS -TESZTELŐ**<br>
5 0613 12 03

Dokumentáció

Készítette:<br>
Csontos Kincső <br>
Szekeres Levente<br>

**2025**

</div>

<div style="page-break-before: always;"></div>

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
    - 7.2. [Verziókezelési Stratégia](#73-verziókezelési-stratégia)
    - 7.3. [FájlStruktúra](#73-fájlstruktúra)

8. [Jövőbeli Tervek](#8-jövőbeli-tervek)
    - 8.1. [Felhasználói fiók bővítések](#81-felhasználói-fiók-bővítések)
    - 8.2. [Nyelvi lokalizáció](#82-nyelvi-lokalizáció)
    - 8.3. [Kétlépcsős hitelesítés](#83-kétlépcsős-hiteleítés)
    - 8.4. [AI-alapú keresés és javaslatok](#84-ai-alapú-keresés-és-javaslatok)
    - 8.5. [Gamifikáció](#85-gamifikáció)
    - 8.6. [Mobil Applikáció](#86-mobil-applikáció)
    - 8.7. [Asztali Alkalmazás](#87-asztali-alkalmazás)

9. [Ki mit készített?](#9-ki-mit-készített?)
    - 10.1. [Csontos Kincső](#91-csontos-kincső)
    - 10.2. [Szekeres Levente](#92-szekeres-levente)

10. [Licensz](#10-licensz)

<div style="page-break-before: always;"></div>

## 1. Bevezetés

### 1.1. A Projekt Célja

A **NoteShare** egy modern, közösségi alapú, oktatássegítő platform, amely lehetővé teszi a diákok számára, hogy egyszerűen és biztonságosan megosszák egymással jegyzeteiket, segédanyagaikat és tanulást támogató dokumentumaikat. A projekt célja, hogy:

* **Kik használják?**
Diákok, tanárok és oktatók, akik megosztanák egymással az oktatási anyagokat.

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


---

### 1.2. Főbb Funkciók

A NoteShare rendszer az alábbi kulcsfunkciókat biztosítja:

### Fájlfeltöltés és -kezelés

- Jegyzetek és segédanyagok feltöltése PDF, DOCX, MP4 formátumban
- Automatikus kategorizálás tantárgy és dokumentumtípus szerint
- Előnézeti kép generálása (PDF első oldal, képek)

### Felhasználói felület

- Regisztráció és bejelentkezés (alap és "OAuth")
- Egyéni irányítópult a feltöltések, letöltések, értékelések követésére
- Mobilbarát és reszponzív dizájn

### Keresés és közösségi funkciók

- Kulcsszavas kereső és szűrő (tantárgy, értékelés alapján)
- Kommentelés, csillagozás
- Legnépszerűbb jegyzetek és új feltöltések kiemelése

### Adminisztráció és jogosultságok

- Admin felület a tartalmak, felhasználók és kategóriák kezeléséhez
- Feltöltések jelentése és moderálása

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
   - `registration_date` DATETIME NOT NULL DEFAULT current_timestamp()

2. files
   - `id` (INT, AUTO_INCREMENT)
   - `uploaded_by` (INT)
   - `name` (VARCHAR(255))
   - `file_name` (VARCHAR(255))
   - `description` (TEXT)
   - `file_path` (VARCHAR(255))
   - `subject` (VARCHAR(100))
   - `tags` (VARCHAR(100))
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
- Nyisd meg a `db.php` fájlt.
- Győződj meg róla, hogy az adatbázis hitelesítési adatok megfelelnek a helyi szerver beállításainak.
4. Indítsd el a helyi szervert, és navigálj a `http://localhost/NoteShare/` címre a böngésződben.
```

#### 6.2. Használat 

1. Felhasználói Regisztráció
    1. Navigálj a `reglog.php` oldalra.
    2. Töltsd ki a szükséges mezőket (vezetéknév, keresztnév, felhasználónév, email cím. jelszó, biztonsági válasz).
    3. Kattints a `Regisztráció` gombra.

2. Bejelentkezés
    1. Navigálj a `reglog.php` oldalra.
    2. Kattints a `Lépj be!` linkre
    3. Add meg a felhasználónevedet és jelszavadat.
    4. Kattints a `Bejelentkezés` gombra.

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

<div style="page-break-before: always;"></div>

### 7. Fejlesztői Dokumentáció

### 7.1. Fejlesztői Környezet Beállítása
```bash
1. Klónozd le a projekt fájljait (pl. `git clone https://github.com/doomhyena/NoteShare-Dev.git`) a helyi szerver gyökérkönyvtárába (pl. `c:/xampp/htdocs/NoteShare-Dev`).
2. Importáld az adatbázist:
- Nyisd meg a phpMyAdmin-t.
- Importáld a `noteshare.sql` fájlt az `assets/sql/` mappából.
3. Konfiguráld az adatbázis kapcsolatot:
- Nyisd meg a `db.php` fájlt.
- Győződj meg róla, hogy az adatbázis hitelesítési adatok megfelelnek a helyi szerver beállításainak.
4. Indítsd el a helyi szervert, és navigálj a `http://localhost/NoteShare/` címre a böngésződben.
```
### 7.2. Verziókezelési Stratégia
- **Main branch**: Stabil, éles verzió.
- **Feature branch-ek**: Új funkciók fejlesztésére.

### 7.3. FájlStruktúra

```bash

NoteShare-Dev/
│   ├──/assets
│   │
│   ├── /css
│   │   └── styles.css                      # A projekt stíluslapja
│   ├──/img
│   │   ├── default_profile_picture.png     # Alapértelmezett profilkép azoknak akik nem állítottak be profilképet
│   │   ├── favicon.ico                     # Az alkalmazás faviconja
│   │   ├── logo-1.png                      # Az első logó
│   │   └── logo-2.png                      # A második logó
│   ├──/js
│   │   └── script.js                       # A JavaScript fájl, amely a fő funkciókat tartalmazza
│   ├──/php
│   │   ├── accept_friend.php               # Barátok elfogadását kezelő fájl
│   │   ├── add_friend.php                  # Barátok hozzáadását kezelő fájl
│   │   ├── db.php                          # Az adatbázis kapcsolat beállításait tartalmazó fájl
│   │   ├── delete.php                      # Fájlok törlését kezelő fájl
│   │   ├── download.php                    # Fájlok letöltését kezelő fájl
│   │   ├── findanything.php                # Keresési funkciót megvalósító fájl
│   │   ├── footer.php                      # A footer-t megjelenítő fájl
│   │   ├── loadmessages.php                # Üzenetek betöltését kezelő fájl
│   │   ├── logout.php                      # Kijelentkezést kezelő fájl
│   │   └── navbar.php                      # navbar-t megjelenítő fájé
│   ├── /sql
│   │   └── noteshare.sql                   # Az oldal adatbázisa
├── users/                                  # Felhasználók tárhelyét tartalmazó mappa
├── edit_email.php                          # Az email cím módosításáért felelős fájl
├── Év végi feladat.pdf                     # A feladatot leíró dokumentum
├── forgotpass.php                          # Jelszó visszaállítást kezelő fájl
├── index.php                               # Az oldal főoldala
├── LICENSE                                 # Az oldal licensze
├── messages.php                            # Az üzenetküldéséért és fogadásáért felelős fájé
├── notify.php                              # Értesítéseket kezelő fájl
├── profile.php                             # Profilokat megjelenítő fájl
├── README.md                               # Az oldal dokumentációja markdown fájlként
├── reglog.php                              # Bejelentkezést és a regisztrációt kezelő fájl
├── search.php                              # Keresést kezelő fájl
└── upload.php                              # Feltöltést kezelő fájl

```

## 8. Jövőbeli Tervek
#### 8.1. Felhasználói fiók bővítések

A NoteShare egyik jövőbeli fejlesztési iránya a felhasználói profilok bővítése és személyre szabása. A cél, hogy a felhasználók saját igényeik szerint alakíthassák profiljukat, ezzel is növelve a közösségi élményt és az elköteleződést.

**Főbb lehetőségek:**
- **Profilkép feltöltése és módosítása:** A felhasználók egyéni profilképet állíthatnak be, amely megjelenik a hozzászólásoknál, feltöltéseknél és a profiloldalon.
- **Bemutatkozás megadása:** Lehetőség rövid szöveges bemutatkozás hozzáadására, amely segíti a közösségi kapcsolatok kialakítását.
- **Érdeklődési körök beállítása:** A felhasználók megadhatják, hogy mely tantárgyak, témák vagy kategóriák érdeklik őket. Ezek alapján a rendszer személyre szabott ajánlásokat és tartalmakat jeleníthet meg.
- **További személyes adatok kezelése:** Opcionális mezők, mint például elérhetőségek, közösségi média linkek vagy tanulmányi adatok.

**Előnyök:**
- Személyre szabottabb élmény és ajánlások
- Közösségi kapcsolatok erősítése
- Felhasználói aktivitás növelése

#### 8.2. Nyelvi lokalizáció

A NoteShare célja, hogy minél szélesebb körben elérhető legyen, ezért a felület több nyelven is használhatóvá válik. A lokalizáció lehetővé teszi, hogy a felhasználók a számukra legkényelmesebb nyelven használják az alkalmazást.

**Főbb funkciók:**
- **Többnyelvű felület:** A rendszer magyar és angol nyelven is elérhető lesz, később további nyelvekkel bővíthető.
- **Nyelvválasztás a beállításokban:** A felhasználók a profiljukban vagy a beállítások menüben választhatják ki a preferált nyelvet.
- **Automatikus nyelvfelismerés:** A rendszer képes lehet felismerni a böngésző vagy az operációs rendszer nyelvét, és ennek megfelelően állítja be az alapértelmezett nyelvet.
- **Fordítási támogatás:** A tartalmak, üzenetek és értesítések is a kiválasztott nyelven jelennek meg.

**Előnyök:**
- Nemzetközi felhasználók elérése
- Felhasználói élmény javítása
- Könnyebb bevezetés új piacokon

#### 8.3. Kétlépcsős hitelesítés

A biztonság növelése érdekében a NoteShare támogatni fogja a kétlépcsős hitelesítést (2FA), amely jelentősen csökkenti a jogosulatlan hozzáférés kockázatát.

**Főbb funkciók:**
- **Másodlagos azonosítás:** Bejelentkezéskor a felhasználónak egy egyszer használatos kódot is meg kell adnia, amelyet SMS-ben vagy e-mailben kap meg.
- **Beállítási lehetőség:** A kétlépcsős hitelesítés opcionálisan bekapcsolható a profilbeállításokban.
- **Biztonsági mentési kódok:** Elveszett eszköz esetén a felhasználók előre generált biztonsági kódokkal is beléphetnek.
- **Értesítések gyanús bejelentkezésekről:** A rendszer figyelmeztetést küld, ha ismeretlen eszközről vagy helyről próbálnak bejelentkezni.

**Előnyök:**
- Fiókbiztonság jelentős növelése
- Felhasználói adatok védelme
- Bizalom erősítése a platform iránt

#### 8.4. AI-alapú keresés és javaslatok

A NoteShare fejlesztése során gépi tanulási és mesterséges intelligencia (AI) megoldások is bevezetésre kerülnek, hogy a felhasználók gyorsabban és hatékonyabban találják meg a számukra releváns tartalmakat.

**Főbb funkciók:**
- **Személyre szabott ajánlások:** Az AI elemzi a felhasználó korábbi kereséseit, letöltéseit és érdeklődési köreit, majd ezek alapján ajánl új jegyzeteket vagy segédanyagokat.
- **Intelligens kereső:** A keresési találatok sorrendjét a rendszer a felhasználó szokásaihoz és preferenciáihoz igazítja.
- **Tartalom szűrés és kategorizálás:** Az AI segít a feltöltött anyagok automatikus címkézésében és kategorizálásában.
- **Tanulási útvonalak ajánlása:** A rendszer javaslatokat adhat, hogy milyen anyagokat érdemes elolvasni egy adott témakörben.

**Előnyök:**
- Gyorsabb és pontosabb keresés
- Személyre szabott tanulási élmény
- Nagyobb felhasználói elégedettség

#### 8.5. Gamifikáció

A felhasználói aktivitás ösztönzése érdekében a NoteShare gamifikációs elemeket vezet be, amelyek játékosabbá és motiválóbbá teszik a platform használatát.

**Főbb funkciók:**
- **Pontgyűjtés:** A felhasználók pontokat szerezhetnek különböző tevékenységekért, például regisztrációért, jegyzetfeltöltésért, hozzászólásért vagy értékelésért.
- **Jelvények és rangok:** Különféle mérföldkövek eléréséért (pl. első feltöltés, 100. letöltés) digitális jelvényeket és rangokat kapnak a felhasználók.
- **Ranglisták:** A legaktívabb vagy legnépszerűbb felhasználók megjelennek a közösségi ranglistákon.
- **Kihívások és küldetések:** Időszakos vagy tematikus kihívások teljesítésével további jutalmak szerezhetők.

**Előnyök:**
- Felhasználói elköteleződés növelése
- Közösségi aktivitás ösztönzése
- Pozitív visszacsatolás a felhasználók számára

#### 8.6. Mobil Applikáció

A NoteShare jövőbeli fejlesztési tervei között szerepel egy natív mobilalkalmazás elkészítése Android és iOS platformokra. A mobil app célja, hogy a felhasználók még kényelmesebben érhessék el a jegyzeteket, tölthessenek fel fájlokat, és kommunikálhassanak egymással útközben is.

**Főbb funkciók:**
- Jegyzetek böngészése, letöltése és feltöltése közvetlenül a mobilról
- Push értesítések új üzenetekről, barátkérésekről, kommentekről
- Felhasználói profil szerkesztése, profilkép módosítása
- Barátok kezelése, üzenetküldés
- Offline elérés a letöltött jegyzetekhez

**Technológiai lehetőségek:**
- **React Native** vagy **Flutter** a multiplatform fejlesztéshez
- REST API integráció a meglévő backenddel
- Biztonságos bejelentkezés és adatkezelés

#### 8.7. Asztali Alkalmazás

A platform funkcionalitásának bővítése érdekében egy asztali alkalmazás fejlesztése is tervben van Windows, macOS és Linux rendszerekre. Az asztali kliens célja, hogy a felhasználók gyorsabban és kényelmesebben kezelhessék nagyobb mennyiségű jegyzetet, illetve integráltabb élményt nyújtson az operációs rendszerrel.

**Főbb funkciók:**
- Fájlok drag & drop feltöltése közvetlenül a gépről
- Jegyzetek gyors keresése, szűrése és letöltése
- Értesítések az asztali környezetben
- Automatikus szinkronizáció a webes és mobil platformmal

**Technológiai lehetőségek:**
- **Electron** vagy **Tauri** keretrendszer a cross-platform fejlesztéshez
- REST API vagy WebSocket kapcsolat a szerverrel
- Integráció a rendszer értesítési szolgáltatásaival

Ezek a fejlesztések jelentősen növelnék a NoteShare elérhetőségét és felhasználói élményét minden platformon.

## 9. Ki mit készített?

### 9.1. Csontos Kincső

- **Backend Fejlesztés**: Backend logika, adatbázis kapcsolat.
- **Adatbázis Tervezés**: Adatbázis struktúra és SQL szkriptek.
- **Dokumentáció**: Projekt dokumentáció elkészítése.
- **Tesztelés**: Funkcionális tesztek végrehajtása.

### 9.2. Szekeres Levente

- **Backend Fejlesztés**: Backend logika, adatbázis kapcsolat.
- **Frontend Fejlesztés**: Felhasználói felület tervezése és reszponzív dizájn
- **Tesztelés**: Funkcionális tesztek végrehajtása.

<div style="page-break-before: always;"></div>

## 10. Licensz
Ez a projekt saját projektmunkás licensz alatt áll. A forráskód és a dokumentáció kizárólag oktatási célokra használható fel, kereskedelmi felhasználása nem engedélyezett.

A felhasználók vállalják, hogy nem töltenek fel jogvédett tartalmat.
