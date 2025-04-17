-- Created by: Csontos Kincső 13/A
-- Létrehozva: 2025. április 16., szerda, 19:26:44
-- Leírás: SQL-szkript a NoteShare alkalmazás adatbázisának és tábláinak létrehozásához.
--Ez a parancsfájl létrehozza a NoteShare alkalmazás adatbázisát és tábláit, beleértve a felhasználókat, fájlokat, osztályokat, ütemezéseket, feladatokat és osztályzatokat.

CREATE DATABASE IF NOT EXISTS NoteShare;
USE NoteShare;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lastname VARCHAR(100),
    firstname VARCHAR(100),
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    security_question VARCHAR(255) NOT NULL,
    security_answer VARCHAR(255) NOT NULL
    admin TINYINT(1) DEFAULT 0,
    teacher TINYINT(1) DEFAULT 0,
);

CREATE TABLE IF NOT EXISTS files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    title VARCHAR(255),
    description TEXT,
    file_path VARCHAR(255) NOT NULL,
    uploaded_by INT,
    FOREIGN KEY (uploaded_by) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS class_students (
    class_id INT,
    student_id INT,
    PRIMARY KEY (class_id, student_id),
    FOREIGN KEY (class_id) REFERENCES classes(id),
    FOREIGN KEY (student_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT,
    day_of_week ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    subject VARCHAR(255) NOT NULL,
    teacher_id INT,
    details TEXT,
    FOREIGN KEY (class_id) REFERENCES classes(id),
    FOREIGN KEY (teacher_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT,
    title VARCHAR(255),
    grade VARCHAR(10),
    description TEXT,
    FOREIGN KEY (class_id) REFERENCES classes(id)
);

CREATE TABLE IF NOT EXISTS grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    grade VARCHAR(10),
    FOREIGN KEY (student_id) REFERENCES users(id)
);

INSERT INTO `files` (`id`, `userid`, `name`, `file_name`, `tn_name`) VALUES
(1, 3, 'C Jegyzetek', 'CNotesForProfessionals.pdf', 'C:xampp	mpphpAD22.tmp'),
(3, 4, 'CSS jegyzetek', 'CSSNotesForProfessionals.pdf', 'C:xampp	mpphp925D.tmp');

INSERT INTO `users` (`id`, `lastname`, `firstname`, `username`, `profile_picture`, `password`, `teacher`, `admin`) VALUES
(3, 'Csontos', 'Kincső', 'doomhyena', '618462_4xEbsnTA.png', '$2y$10$EwcPqq6Aw7/m39popdXq.uH45xjtV6knsEnKZ/gfJo/.dwXvp6Wzm', 0, 1),
(4, 'Teszt', 'User', 'tesztuser', '', '$2y$10$CI1lsAN6RWADb9L6otlv9eGxsTFAJ0H0KSdy9j.FT3IopoYSXbjBS', 0, 0);
