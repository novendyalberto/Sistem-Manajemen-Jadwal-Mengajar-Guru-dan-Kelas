CREATE DATABASE IF NOT EXISTS db_jadwal_guruu;
USE db_jadwal_guruu;

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
nama_lengkap VARCHAR(100),
email VARCHAR(100),
username VARCHAR(50),
PASSWORD VARCHAR(255),
foto VARCHAR(255) NULL
);

CREATE TABLE guru (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_guru VARCHAR(100) NOT NULL,
    mapel VARCHAR(100) NOT NULL
);

CREATE TABLE kelas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kelas VARCHAR(50),
    tingkat VARCHAR(10)
);

CREATE TABLE jadwal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_guru INT,
    id_kelas INT,
    hari VARCHAR(20),
    jam_mulai TIME,
    jam_selesai TIME,
    FOREIGN KEY (id_guru) REFERENCES guru(id),
    FOREIGN KEY (id_kelas) REFERENCES kelas(id)
);