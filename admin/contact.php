<?php
require 'config.php'; // Connexion DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // 1. Enregistrement en base
    $sql = "INSERT INTO messages (name, email, subject, message) VALUES (:name, :email, :subject, :message)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':subject' => $subject,
        ':message' => $message
    ]);

    // 2. Envoi email
    $to = "nodtechnologie@gmail.com";
    $email_subject = "📩 Nouveau message: $subject";
    $email_body = "
    Nom: $name\n
    Email: $email\n
    Sujet: $subject\n
    Message:\n$message
    ";
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "✅ Message envoyé et enregistré avec succès.";
    } else {
        echo "⚠️ Enregistré en base, mais l'envoi d'email a échoué.";
    }
}
?>
