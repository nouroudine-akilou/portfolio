<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
require 'config.php'; // Connexion DB

// Suppression d’un message
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $pdo->prepare("DELETE FROM messages WHERE id = :id")->execute([':id' => $id]);
    header("Location: admin.php");
    exit;
}

// Récupération des messages
$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau d'administration - Messages</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white shadow-md z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                <div class="w-20 h-15 rounded-full flex items-center justify-center mr-3">
                    <!-- <span class="text-white font-bold text-xl">NT</span> -->
                     <img src="../image/logo nod1.png" alt="">
                </div>
                <!-- <h1 class="text-xl font-bold text-primary-800">NOD Technologie</h1> -->
            </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="../portfolie.html" class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2">Accueil</a>
                    <a href="logout.php" class="bg-blue-500 text-white px-4 py-2 rounded">Déconnexion</a>
                </div>
                <div class="md:hidden flex items-center">
                    <button id="menu-btn" class="text-gray-700 hover:text-purple-600">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white pb-4">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="../portfolie.html" class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2">Accueil</a>
                    <a href="logout.php" class="bg-blue-500 text-white px-4 py-2 rounded"> Déconnexion</a>
            </div>
        </div>
    </nav>


    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">📩 Messages reçus</h1>

        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border">ID</th>
                    <th class="py-2 px-4 border">Nom</th>
                    <th class="py-2 px-4 border">Email</th>
                    <th class="py-2 px-4 border">Sujet</th>
                    <th class="py-2 px-4 border">Date</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($messages) > 0): ?>
                    <?php foreach ($messages as $msg): ?>
                        <tr>
                            <td class="py-2 px-4 border"><?= $msg['id'] ?></td>
                            <td class="py-2 px-4 border"><?= htmlspecialchars($msg['name']) ?></td>
                            <td class="py-2 px-4 border"><?= htmlspecialchars($msg['email']) ?></td>
                            <td class="py-2 px-4 border"><?= htmlspecialchars($msg['subject']) ?></td>
                            <td class="py-2 px-4 border"><?= htmlspecialchars($msg['created_at']) ?></td>
                            <td class="py-2 px-4 border">
                                <a href="view.php?id=<?= $msg['id'] ?>" class="bg-blue-500 text-white px-3 py-1 rounded">Voir</a>
                                <a href="mailto:<?= htmlspecialchars($msg['email']) ?>?subject=Réponse à: <?= urlencode($msg['subject']) ?>" 
                                class="bg-green-500 text-white px-3 py-1 rounded">Répondre</a>
                                <a href="admin.php?delete=<?= $msg['id'] ?>" 
                                class="bg-red-500 text-white px-3 py-1 rounded" 
                                onclick="return confirm('Supprimer ce message ?')">Supprimer</a>
                            </td>
                            
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center py-4">Aucun message reçu</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>
