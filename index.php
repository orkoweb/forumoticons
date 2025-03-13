<?php
// Renforcement de la sécurité des sessions
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    ini_set('session.cookie_secure', 1);
}
session_start();

$directory = __DIR__; // Utilise le répertoire courant où se trouve index.php
$images = glob($directory . "/*.{png,gif,jpg,jpeg}", GLOB_BRACE);
// Filtrer pour exclure favicon.png
$images = array_filter($images, function($image) {
    return basename($image) !== "favicon.png";
});
natcasesort($images); // Trie les fichiers par ordre alphabétique, insensible à la casse
$smileyPath = "https://domain.tld/dossier/"; // Modifie avec ton URL de base
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="favicon.png" sizes="32x32">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>Forumoticons</title>
    <style>
        body { font-family: monospace; text-align: center; background-color: #a0a0a0; color:#1e1e1e; }
        .grid { max-width:980px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; }
        .smiley { cursor: pointer; transition: transform 0.2s; width: 25px; height: 25px; }
        .smiley:hover { transform: scale(1.4); }
        .copied-message { position: fixed; bottom: 10px; left: 50%; transform: translateX(-50%); background: #4CAF50; color: white; padding: 5px 10px; border-radius: 5px; display: none; }
        header { max-width: 980px; margin:40px auto; text-align: center; padding: 10px; }
        h1 { margin:0; font-size: 32px; letter-spacing: 6px;}
        .upload-form { display: flex; flex-direction: column; align-items: center; gap: 10px; margin-top: 10px; }
        .upload-form input, .upload-form button { font-size: 14px; padding: 5px; }
        .upload-form button {
            font-family: monospace;
            font-size: 14px;
            background: #000;
            color: #fff;
            border: 3px solid #fff;
            padding: 8px 16px;
            cursor: pointer;
            text-transform: uppercase;
            box-shadow: 4px 4px 0px #555;
            transition: transform 0.1s, box-shadow 0.1s;
        }
        .upload-form button:active {
            transform: translate(2px, 2px);
            box-shadow: 2px 2px 0px #555;
        }
        .status-message {
            margin-top: 10px;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
        }
        .status-success { background: #4CAF50; }
        .status-error { background: #D32F2F; }
    </style>
</head>
<body>
    <header>
        <h1>Forumoticons</h1>
        <form action="upload.php" method="POST" enctype="multipart/form-data" class="upload-form">
            <input type="file" name="file" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Envoyer</button>
        </form>
    </header>
    
    <?php if (isset($_GET['status'])): ?>
        <p class="status-message <?= (strpos($_GET['status'], 'incorrect') !== false 
                                      || strpos($_GET['status'], 'Erreur') !== false 
                                      || strpos($_GET['status'], 'trop grande') !== false) 
                                      ? 'status-error' : 'status-success' ?>" id="statusMessage">
            <?= htmlspecialchars($_GET['status']); ?>
        </p>
    <?php endif; ?>
    
    <div class="grid" id="smileyGrid">
        <?php foreach ($images as $image): ?>
            <img src="<?= $smileyPath . basename($image) ?>" class="smiley" title="<?= basename($image) ?>" onclick="copyToClipboard('[img]<?= $smileyPath . basename($image) ?>[/img]')">
        <?php endforeach; ?>
    </div>
    <div class="copied-message" id="copiedMessage">Copié !</div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                const copiedMessage = document.getElementById("copiedMessage");
                copiedMessage.style.display = "block";
                setTimeout(() => copiedMessage.style.display = "none", 1500);
            });
        }
        
        document.addEventListener("DOMContentLoaded", function() {
            const statusMessage = document.getElementById("statusMessage");
            if (statusMessage) {
                setTimeout(() => { statusMessage.style.display = "none"; }, 3000);
            }
        });
    </script>
</body>
</html>