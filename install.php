<?php
/**
 * Apri una connessione via PDO per creare
 * un nuovo database e una tabella.
 *
 */
require "config.php";
try {
    $connection = new PDO("mysql:host=$host", $username, $password, $options);
    $sql = file_get_contents("data/inizializza_db.sql");
    $connection->exec($sql);
    
    echo "Il database è stato creato correttamente.";
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}