*English version is available below the French version.*

# Forumoticons

Forumoticons est un script PHP permettant d'afficher une galerie de smileys et de copier leurs liens sous forme de balises `[img]`. Il inclut également un formulaire d'upload sécurisé.

## Prérequis

- Un serveur web avec PHP 7.4 ou supérieur
- Un accès FTP ou SSH pour transférer les fichiers

## Installation

1. **Télécharger l'archive** contenant les fichiers
2. **Décompresser l'archive** sur votre serveur
3. **Déplacer le dossier** à l'emplacement souhaité
4. **Vérifier les permissions** pour permettre l'upload des fichiers (ex: `chmod 755` sur le dossier si nécessaire)

## Configuration

- **Mot de passe d'upload** : Modifier la variable `$password` dans `upload.php`
- **URL des smileys** : Modifier la variable `$smileyPath` dans `index.php`

## Utilisation

- Accéder à la page principale via un navigateur
- Cliquer sur un smiley pour copier son URL `[img]`
- Pour ajouter un smiley, utiliser le formulaire d'upload avec le mot de passe requis

## Notes

- La dimensions maximale des images uploadées et de 100px de largeur et 100px de hauteur.
- Si une image est uploadée avec un nom de fichier identique à une image se trouvant déjà sur le serveur, cette dernière sera écrasée sans avertissement par l'image uploadée.

## Sécurité

- Seuls les fichiers `.png`, `.gif`, `.jpg`, et `.jpeg` sont autorisés
- Une limite de taille est appliquée aux fichiers uploadés (max 100 Ko)
- Protection basique par mot de passe pour l'upload
- Un mécanisme anti-bruteforce limite le nombre de tentatives de connexion erronées (3 maximum) avec un délai de blocage de 60 secondes
- Sécurisation des cookies de session (HttpOnly, secure avec HTTPS, utilisation exclusive de cookies)
- Validation renforcée des noms de fichiers :
  - Translitération des caractères accentués et spéciaux
  - Vérification des noms de fichiers interdits
  - Protection contre les fichiers cachés (commençant par un point)
  - Normalisation des noms de fichiers
  - Génération automatique d'un nom pour les fichiers invalides
- Séparation du code et des données :
  - Utilisation d'un répertoire dédié `/img/` pour les fichiers uploadés
  - Protection contre l'écrasement accidentel des fichiers système
  - Création automatique du répertoire si nécessaire
- Vérification complète des images :
  - Double validation des types MIME avec `finfo` (plus sécurisé que `mime_content_type`)
  - Vérification que le fichier est réellement une image valide
  - Contrôle strict de la correspondance entre type MIME et extension
  - Limitation des dimensions à 100x100 pixels maximum
- Protection renforcée du répertoire d'images via `.htaccess` :
  - Désactivation complète de l'exécution de scripts (.php, .pl, .py, etc.)
  - Restriction aux seuls types d'images autorisés
  - Désactivation de l'interprétation PHP dans le répertoire
  - Prévention du listage du contenu du répertoire
  - En-têtes de sécurité pour prévenir le cross-site scripting
- Messages d'erreur détaillés pour faciliter le diagnostic
- Permissions adaptées sur les fichiers uploadés (chmod 0644)

## Licence

Ce projet est sous licence [CC BY-NC 4.0](https://creativecommons.org/licenses/by-nc/4.0/). Vous pouvez l'utiliser et le modifier, mais pas en tirer profit commercialement.

<div align="center">
    <img src="https://raw.githubusercontent.com/orkoweb/forumoticons/refs/heads/main/forumoticons.png" alt="Forumoticons">
    <p><em>Forumoticons, une fois installé</em>
</div>

---

# Forumoticons (English Version)

Forumoticons is a PHP script that displays a gallery of smileys and allows users to copy their links in the `[img]` format. It also includes a secure upload form.

## Requirements

- A web server with PHP 7.4 or higher
- FTP or SSH access to transfer files

## Installation

1. **Download the archive** containing the files
2. **Extract the archive** on your server
3. **Move the folder** to the desired location
4. **Check permissions** to allow file uploads (e.g., `chmod 755` on the folder if necessary)

## Configuration

- **Upload password**: Modify the `$password` variable in `upload.php`
- **Smileys URL**: Modify the `$smileyPath` variable in `index.php`

## Usage

- Access the main page through a browser
- Click on a smiley to copy its `[img]` URL
- To add a smiley, use the upload form with the required password

## Notes

- The maximum dimensions for uploaded images are 100px in width and 100px in height.
- If an image is uploaded with the same filename as an existing image on the server, the existing file will be overwritten without warning.


## Security

- Only `.png`, `.gif`, `.jpg`, and `.jpeg` files are allowed
- A file size limit is applied to uploaded files (max 100 KB)
- Basic password protection is implemented for uploads
- An anti-bruteforce mechanism limits the number of incorrect login attempts (3 maximum) with a 60-second blocking delay
- Session cookies security (HttpOnly flag, secure flag with HTTPS, cookies-only sessions)
- Enhanced filename validation:
  - Transliteration of accented and special characters
  - Verification against forbidden filenames
  - Protection against hidden files (starting with a dot)
  - Filename normalization
  - Automatic name generation for invalid files
- Separation of code and data:
  - Dedicated `/img/` directory for uploaded files
  - Protection against accidental system file overwriting
  - Automatic directory creation if needed
- Complete image verification:
  - Double MIME type validation with `finfo` (more secure than `mime_content_type`)
  - Verification that the file is actually a valid image
  - Strict control of the match between MIME type and extension
  - Limitation of dimensions to a maximum of 100x100 pixels
- Enhanced protection of the image directory via `.htaccess`:
  - Complete disabling of script execution (.php, .pl, .py, etc.)
  - Restriction to only allowed image types
  - Disabling PHP interpretation in the directory
  - Prevention of directory listing
  - Security headers to prevent cross-site scripting
- Detailed error messages to facilitate diagnosis
- Appropriate permissions on uploaded files (chmod 0644)

## License

This project is licensed under [CC BY-NC 4.0](https://creativecommons.org/licenses/by-nc/4.0/). You may use and modify it, but not for commercial purposes.

<div align="center">
    <img src="https://raw.githubusercontent.com/orkoweb/forumoticons/refs/heads/main/forumoticons.png" alt="Forumoticons">
    <p><em>Forumoticons, once installed</em>
</div>