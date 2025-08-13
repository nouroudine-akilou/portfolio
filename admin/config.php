<?php
$host = "localhost"; // ou l'adresse de ton serveur MySQL
$dbname = "nod_technologie";
$username = "root"; // nom d'utilisateur MySQL
$password = ""; // mot de passe MySQL (vide sur XAMPP/WAMP par défaut)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
