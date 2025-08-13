<?php
require 'config.php'; // Connexion à la BDD

// --- Identifiants de l'admin initial ---
$username = "N.Akilou"; // Nom d'utilisateur
$password = password_hash("annour227", PASSWORD_DEFAULT); // Mot de passe sécurisé

try {
    $sql = "INSERT INTO admins (username, password) VALUES (:username, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':username' => $username,
        ':password' => $password
    ]);
    echo "✅ Admin ajouté avec succès.";
} catch (PDOException $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
