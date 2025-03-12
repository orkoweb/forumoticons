*English version is available below the French version.*

# Forumoticons

Forumoticons est un script PHP permettant d'afficher une galerie de smileys et de copier leurs liens sous forme de balises `[img]`. Il inclut également un formulaire d'upload sécurisé.

## Prérequis

- Un serveur web avec PHP 7.4 ou supérieur
- Un accès FTP ou SSH pour transférer les fichiers

## Installation

1. **Télécharger l’archive** contenant les fichiers
2. **Décompresser l’archive** sur votre serveur
3. **Déplacer le dossier** à l’emplacement souhaité
4. **Vérifier les permissions** pour permettre l’upload des fichiers (ex: `chmod 755` sur le dossier si nécessaire)

## Configuration

- **Mot de passe d’upload** : Modifier la variable `$password` dans `upload.php`
- **URL des smileys** : Modifier la variable `$smileyPath` dans `index.php`

## Utilisation

- Accéder à la page principale via un navigateur
- Cliquer sur un smiley pour copier son URL `[img]`
- Pour ajouter un smiley, utiliser le formulaire d’upload avec le mot de passe requis

## Notes

- La dimensions maximale des images uploadées et de 100px de largeur et 100px de hauteur.
- Si une image est uploadée avec un nom de fichier identique à une image se trouvant déjà sur le serveur, cette dernière sera écrasée sans avertissement par l'image uploadée.

## Sécurité

- Seuls les fichiers `.png`, `.gif`, `.jpg`, et `.jpeg` sont autorisés
- Une limite de taille est appliquée aux fichiers uploadés
- Protection basique par mot de passe pour l’upload
- Un mécanisme anti-bruteforce limite le nombre de tentatives de connexion erronées pour protéger l’accès au formulaire d’upload

## Licence

Ce projet est sous licence [CC BY-NC 4.0](https://creativecommons.org/licenses/by-nc/4.0/). Vous pouvez l’utiliser et le modifier, mais pas en tirer profit commercialement.

<div style="text-align: center;">
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
- A file size limit is applied to uploaded files
- Basic password protection is implemented for uploads
- An anti-bruteforce mechanism limits the number of incorrect login attempts to protect access to the upload form

## License

This project is licensed under [CC BY-NC 4.0](https://creativecommons.org/licenses/by-nc/4.0/). You may use and modify it, but not for commercial purposes.

![Forumoticons](https://raw.githubusercontent.com/orkoweb/forumoticons/refs/heads/main/forumoticons.png)
*Forumoticons, once installed*
