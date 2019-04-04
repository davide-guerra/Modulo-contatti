CREATE DATABASE contatti;

  use contatti;

  CREATE TABLE utenti (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(30) NOT NULL,
    cognome VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    telefono INT(12),
    indirizzo VARCHAR(50),
    date TIMESTAMP
  );