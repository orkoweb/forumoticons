<?php
session_start();

$uploadDir = __DIR__ . "/"; // Dossier où enregistrer les fichiers
$allowedTypes = ['image/png', 'image/jpeg', 'image/gif'];
$allowedExtensions = ['png', 'jpg', 'jpeg', 'gif'];
$maxFileSize = 500000; // 500 Ko max
$password = "test"; // À changer !

// Initialisation des tentatives de connexion
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}

// Vérifier si trop de tentatives
if ($_SESSION['attempts'] >= 3) {
    $timeSinceLastAttempt = time() - $_SESSION['last_attempt_time'];
    if ($timeSinceLastAttempt < 60) { // Bloqué pendant 60 secondes
        header("Location: index.php?status=Trop de tentatives. Réessayez plus tard.");
        exit();
    } else {
        $_SESSION['attempts'] = 0; // Réinitialiser après délai
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification du mot de passe
    if (!isset($_POST['password']) || $_POST['password'] !== $password) {
        $_SESSION['attempts']++;
        $_SESSION['last_attempt_time'] = time();
        header("Location: index.php?status=Mot de passe incorrect !");
        exit();
    }
    
    // Vérification du fichier uploadé
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        header("Location: index.php?status=Erreur lors de l'upload !");
        exit();
    }

    $file = $_FILES['file'];
    $fileType = mime_content_type($file['tmp_name']);
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Vérification du type et de l'extension
    if (!in_array($fileType, $allowedTypes) || !in_array($fileExtension, $allowedExtensions)) {
        header("Location: index.php?status=Format non autorisé !");
        exit();
    }

    // Vérification de la taille
    if ($file['size'] > $maxFileSize) {
        header("Location: index.php?status=Fichier trop volumineux !");
        exit();
    }

    // Sécurisation du nom du fichier
    $fileName = basename($file['name']);
    $fileName = preg_replace("/[^a-zA-Z0-9._-]/", "", $fileName); // Suppression des caractères dangereux
    $destination = $uploadDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        header("Location: index.php?status=Upload réussi !");
    } else {
        header("Location: index.php?status=Erreur lors du déplacement du fichier !");
    }
}
?>
