-- Created by: Csontos Kincső 13/A
-- Létrehozva: 2025. április 16., szerda, 19:26:44
-- Leírás: SQL-szkript a NoteShare alkalmazás adatbázisának és tábláinak létrehozásához.

CREATE DATABASE IF NOT EXISTS NoteShare;
USE NoteShare;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lastname VARCHAR(100),
    firstname VARCHAR(100),
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    security_question VARCHAR(255) NOT NULL,
    security_answer VARCHAR(255) NOT NULL,
    admin TINYINT(1) DEFAULT 0,
    teacher TINYINT(1) DEFAULT 0
);

CREATE TABLE IF NOT EXISTS files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uploaded_by INT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    file_path VARCHAR(255) NOT NULL,
    tn_name VARCHAR(255),
    FOREIGN KEY (uploaded_by) REFERENCES users(id)
);

INSERT INTO `files` (`id`, `uploaded_by`, `name`, `description`, `file_path`, `tn_name`) VALUES
(1, 2, 'C Jegyzetek', 'CNotesForProfessionals.pdf', `C Jegyzetek`, 'C:xampp	mpphpAD22.tmp'),
(2, 1, 'CSS jegyzetek', 'CSSNotesForProfessionals.pdf', ``, 'C:xampp	mpphp925D.tmp');

CREATE TABLE IF NOT EXISTS classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS class_members (
    class_id INT,
    member_id INT,
    PRIMARY KEY (class_id, member_id),
    FOREIGN KEY (class_id) REFERENCES classes(id),
    FOREIGN KEY (member_id) REFERENCES users(id)
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
    subject VARCHAR(255) NOT NULL,
    entered_by INT,
    FOREIGN KEY (student_id) REFERENCES users(id),
    FOREIGN KEY (entered_by) REFERENCES users(id)
);



INSERT INTO `users` (`id`, `lastname`, `firstname`, `username`, `profile_picture`, `password`, `teacher`, `admin`) VALUES
(2, 'Csontos', 'Kincső', 'doomhyena', '618462_4xEbsnTA.png', '$2y$10$EwcPqq6Aw7/m39popdXq.uH45xjtV6knsEnKZ/gfJo/.dwXvp6Wzm', 0, 1),
(1, 'Kelemen ', 'Boldizsár', 'tesztuser', '', '$2y$10$CI1lsAN6RWADb9L6otlv9eGxsTFAJ0H0KSdy9j.FT3IopoYSXbjBS', 0, 0);
