# FoRuMoTiCoNs

FoRuMoTiCoNs est un script PHP permettant d'afficher une galerie de smileys et de copier leurs liens sous forme de balises `[img]`. Il inclut également un formulaire d'upload sécurisé.

## Prérequis

- Un serveur web avec PHP 7.4 ou supérieur
- Un accès FTP ou SSH pour transférer les fichiers

## Installation

1. **Télécharger l’archive** contenant les fichiers.
2. **Décompresser l’archive** sur votre serveur.
3. **Déplacer le dossier** à l’emplacement souhaité.
4. **Vérifier les permissions** pour permettre l’upload des fichiers (ex: `chmod 755` sur le dossier si nécessaire).

## Utilisation

- Accéder à la page principale via un navigateur.
- Cliquer sur un smiley pour copier son URL `[img]`.
- Pour ajouter un smiley, utiliser le formulaire d’upload avec le mot de passe requis.

## Configuration

- **Mot de passe d’upload** : Modifier la variable `$correctPassword` dans `upload.php`.
- **URL des smileys** : Modifier la variable `$smileyPath` dans `index.php` si nécessaire.

## Sécurité

- Seuls les fichiers `.png`, `.gif`, `.jpg`, et `.jpeg` sont autorisés.
- Une limite de taille est appliquée aux fichiers uploadés.
- Protection basique par mot de passe pour l’upload.

## Licence

Ce projet est sous licence [CC BY-NC 4.0](https://creativecommons.org/licenses/by-nc/4.0/). Vous pouvez l’utiliser et le modifier, mais pas en tirer profit commercialement.
# FoRuMoTiCoNs
