<?php
// Renforcement de la sécurité des sessions
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    ini_set('session.cookie_secure', 1);
}
session_start();

$uploadDir = __DIR__ . "/img/"; // Dossier dédié pour les uploads

// Vérifier si le répertoire existe, sinon le créer
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$allowedTypes = ['image/png', 'image/jpeg', 'image/gif'];
$allowedExtensions = ['png', 'jpg', 'jpeg', 'gif'];
$maxFileSize = 100000; // 100 Ko max
$password = "test"; // À changer !

// Liste des noms de fichiers interdits
$forbiddenFiles = [
    '.htaccess', 
    'index.php', 
    'upload.php', 
    'config.php', 
    '.env', 
    'web.config',
    'favicon.ico',
    'favicon.png',
    'README.md',
    'forumoticons.png'
];

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
    // Vérification du mot de passe (conservé tel quel comme demandé)
    if (!isset($_POST['password']) || $_POST['password'] !== $password) {
        $_SESSION['attempts']++;
        $_SESSION['last_attempt_time'] = time();
        header("Location: index.php?status=Mot de passe incorrect !");
        exit();
    }
    
    // Vérification du fichier uploadé
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE => "Le fichier dépasse la limite autorisée par PHP",
            UPLOAD_ERR_FORM_SIZE => "Le fichier dépasse la limite autorisée par le formulaire",
            UPLOAD_ERR_PARTIAL => "Le fichier n'a été que partiellement téléchargé",
            UPLOAD_ERR_NO_FILE => "Aucun fichier n'a été téléchargé",
            UPLOAD_ERR_NO_TMP_DIR => "Dossier temporaire manquant",
            UPLOAD_ERR_CANT_WRITE => "Échec de l'écriture du fichier sur le disque",
            UPLOAD_ERR_EXTENSION => "Une extension PHP a arrêté l'envoi de fichier"
        ];
        
        $errorCode = isset($_FILES['file']) ? $_FILES['file']['error'] : UPLOAD_ERR_NO_FILE;
        $errorMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : "Erreur inconnue lors de l'upload !";
        
        header("Location: index.php?status=" . urlencode($errorMessage));
        exit();
    }

    $file = $_FILES['file'];
    
    // Vérification du type MIME avec finfo (plus sécurisé)
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $fileType = $finfo->file($file['tmp_name']);
    
    // Vérification de l'extension
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Vérifier que le fichier est bien une image valide
    $imageInfo = @getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        header("Location: index.php?status=Le fichier n'est pas une image valide !");
        exit();
    }

    // Double vérification - type MIME et extension
    if (!in_array($fileType, $allowedTypes) || !in_array($fileExtension, $allowedExtensions)) {
        header("Location: index.php?status=Format non autorisé ! Type détecté : " . htmlspecialchars($fileType));
        exit();
    }

    // Vérification que le type MIME correspond à l'extension
    $mimeExtensionMap = [
        'image/png' => 'png',
        'image/jpeg' => ['jpg', 'jpeg'],
        'image/gif' => 'gif'
    ];

    $validExtension = false;
    if (isset($mimeExtensionMap[$fileType])) {
        if (is_array($mimeExtensionMap[$fileType])) {
            $validExtension = in_array($fileExtension, $mimeExtensionMap[$fileType]);
        } else {
            $validExtension = ($fileExtension === $mimeExtensionMap[$fileType]);
        }
    }

    if (!$validExtension) {
        header("Location: index.php?status=Le type de fichier ne correspond pas à l'extension !");
        exit();
    }

    // Vérification des dimensions de l'image
    list($width, $height) = $imageInfo;
    if ($width > 100 || $height > 100) {
        header("Location: index.php?status=Image trop grande (max 100x100) !");
        exit();
    }

    // Vérification de la taille
    if ($file['size'] > $maxFileSize) {
        header("Location: index.php?status=Fichier trop volumineux (max 100 Ko) !");
        exit();
    }

    // Sécurisation du nom du fichier
    $fileName = basename($file['name']);
    $originalFileName = $fileName;

    // Vérification si le nom commence par un point (fichier caché)
    if (substr($fileName, 0, 1) === '.') {
        header("Location: index.php?status=Nom de fichier non autorisé (fichier caché) !");
        exit();
    }

    // Translitération des caractères accentués et autres caractères spéciaux
    $fileName = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $fileName);
    
    // Suppression des caractères dangereux
    $fileName = preg_replace("/[^a-zA-Z0-9._-]/", "", $fileName);

    // Vérification si le nom est dans la liste des fichiers interdits
    if (in_array(strtolower($fileName), array_map('strtolower', $forbiddenFiles))) {
        header("Location: index.php?status=Nom de fichier non autorisé !");
        exit();
    }

    // Vérification que l'extension correspond à celles autorisées
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedExtensions)) {
        header("Location: index.php?status=Extension de fichier non autorisée !");
        exit();
    }

    // Si le nom a été modifié et est devenu vide, utiliser un nom par défaut
    if (empty($fileName) || $fileName !== $originalFileName) {
        // Si le nom a été uniquement translitéré (même contenu sans accents), on garde ce nom
        // Sinon, on génère un nom par défaut
        if (empty($fileName)) {
            $fileName = 'custom_' . time() . '.' . $fileExtension;
        }
    }

    $destination = $uploadDir . $fileName;
    
    // Conservation de l'écrasement des fichiers comme demandé

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        // Vérifier les permissions du fichier après l'upload
        chmod($destination, 0644); // Permissions réduites pour les fichiers téléchargés
        header("Location: index.php?status=Upload réussi !");
    } else {
        header("Location: index.php?status=Erreur lors du déplacement du fichier !");
    }
}
?>