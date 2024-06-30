SET foreign_key_checks = 0;

DROP TABLE IF EXISTS teachers;

CREATE TABLE teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    encrypted_password VARCHAR(255) NOT NULL,
    gender VARCHAR(65),
    profile_picture VARCHAR(65),
    birth_date DATE
);

DROP TABLE IF EXISTS admins;

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    encrypted_password VARCHAR(255) NOT NULL,
    gender VARCHAR(65),
    profile_picture VARCHAR(65),
    birth_date DATE
);

DROP TABLE IF EXISTS problems;

CREATE TABLE problems (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    teacher_id INT NOT NULL REFERENCES teachers(id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS problem_teacher_reinforce;

CREATE TABLE problem_teacher_reinforce (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT NOT NULL REFERENCES teachers(id) ON DELETE RESTRICT,
    problem_id INT NOT NULL REFERENCES teachers(id) ON DELETE RESTRICT
);

SET foreign_key_checks = 1;