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

3. **comments**
   - `id` (INT, PK, AUTO_INCREMENT)
   - `userid` (INT, FK → users.id)
   - `postid` (INT)
   - `text` (VARCHAR(1000))

4. **notifys**
    - `id` (INT, PK, AUTO_INCREMENT)
    - `fromid` (INT, FK → users.id)
    - `toid` (INT, FK → users.id)
    - `notifytype` (VARCHAR(100))
    - `readed` (TINYINT(1), DEFAULT 0)

5. **namedays**
    - `id` (INT, PK, AUTO_INCREMENT)
    - `datum` (VARCHAR(5))
    - `nevek` (VARCHAR(255))

6. **messages**
    - `id` (INT, PK, AUTO_INCREMENT)
    - `fromid` (INT, FK → users.id)
    - `toid` (INT, FK → users.id)
    - `content` text NOT NULL,
    - `sent_at` date NOT NULL DEFAULT current_timestamp()
---