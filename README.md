# Fisherman-Instruments-Web-Site

## Description
Site Web créé pour l'entreprise SAS Guitares Pecheur dans le cadre de ma première expérience professionnelle et ma soutenance pour le titre DWWM.

Ce site est composé d'un front-office (la partie visible pour l'utilisateur lambda) et d'un back-office (une partie "admin" permettant la modification de certaine partie du site). Pour accéder la partie back-office voir partie "[back-office](#back-office)".
## Installation

1. Cloner le projet depuis le repository Fisherman-Instruments-Web-Site, dans un emplacement souhaité :
```
git clone https://github.com/Sanbye/Fisherman-Instruments-Web-Site.git
```
Puis sélectionner l'emplacement où vous souhaitez installer le projet.

2. Vérifier bien avoir les bonnes versions de PHP et Symfony :

    - PHP 8.1 ou supérieur
    - Symfony 6.1.10 ou supérieur 
   
   Le cas échéant changer les variables d'environnement de votre OS.

3. Une fois dans votre projet, Installer composer (pour extensions et bundles) :

```
composer install
```

Puis composer update :

```
composer update
```
4. Modifier paramètres d'environnement dans le fichier .env (adresse de votre BDD) :

```dotenv
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
```

5. Créer la base de données via l'invite de commande : 
```
symfony console doctrine:database:create
```

6. Récupérer le script SQL créant les tables avec des entitées démo
   
   Le script se trouve dans votre emplacement du projet /DocGuitareShop/SQL script, Demo BDD.


7. Importer le script SQL dans la base de données créée précédemment. 

## Utilisation du site

### front-office

Le site est directement visualisable côté front-office, vous pourrez alors naviguer dans la vitrine du site.

### back-office

Pour entrer dans la partie "back-office" du site et modifier les sections:

1. Dans l'URL, ajouter "/login" après localhost.


2. Connectez-vous à l'un des 2 comptes suivant :
   - username: "ADMIN", mot de passe: "123456". Cet utilisateur possède le rôle "admin" permettant l'ensemble des modifications possibles.
   - username: "test", mot de passe: "123456" Cet ultilisateur possède le rôle "vendeur", il est limité dans la modification du site.

   Vous êtes maintenant connecté en tant qu'administrateur du site, vous pouvez modifier certaines parties de site.

3. Pour retourner en visualisation "front-office", ajouter "/logout" après localhost.