<?php
require 'config.php';

if (!isset($_GET['id'])) {
    die("ID manquant");
}

$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM messages WHERE id = :id");
$stmt->execute([':id' => $id]);
$message = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$message) {
    die("Message introuvable");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail du message</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">📄 Détail du message</h1>
        <p><strong>Nom :</strong> <?= htmlspecialchars($message['name']) ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($message['email']) ?></p>
        <p><strong>Sujet :</strong> <?= htmlspecialchars($message['subject']) ?></p>
        <p><strong>Date :</strong> <?= $message['created_at'] ?></p>
        <hr class="my-4">
        <p><strong>Message :</strong></p>
        <p class="bg-gray-50 p-4 border rounded"><?= nl2br(htmlspecialchars($message['message'])) ?></p>
        <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?= htmlspecialchars($msg['email']) ?>&su=<?= urlencode($msg['subject']) ?>" target="_blank" class="bg-green-500 text-white px-3 py-1 rounded">📧 Répondre</a>
        <a href="admin.php" class="mt-4 inline-block bg-gray-500 text-white px-4 py-2 rounded">⬅ Retour</a>
    </div>
</body>
</html>
