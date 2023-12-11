<?php


// Connexion à la base de données 
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "23_24_b2_jeux_olympiques";

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=23_24_b2_jeux_olympiques", "root", "", [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}