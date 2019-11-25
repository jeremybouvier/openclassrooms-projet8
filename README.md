# TodoList

Réalisation d'une application permettant permettant de consigner des tâches à faire. Chaque utilisateur peut créer son 
compte. Un utilisateur authentifié peut ajouter, modifier, valider et supprimer ces tâches. Les administrateur peuvent 
modifier les informations des comptes utilisateurs. Le projet est basé sur le framework Symfony et inclu les différéents 
tests automatisé du projet. 

### Prérequis

Pour pouvoir utiliser le projet vous aurez besoin de :

* [Mysql 14.14]
* [PHP >=5.5.9]
* [Composer 1.8.5]

### Installation

Pour commencer placez vous dans le répertoire ou vous souhaiter installer le projet.


Télécharger le dossier du projet en faisant un :
```
$ git clone https://github.com/jeremybouvier/openclassrooms-projet8 TodoList
```
placez vous à la racine du projet  :
```
$ cd TodoList
```

Mettez a jour les dépendances composer en faisant un :
```
$ composer update
```

Modifiez les paramètres d'accès à la base de donnée en remplaçant cette ligne dans le fichier parameters.yml présent 
dans le dossier app/config :
```
parameters:
    database_host: 127.0.0.1 <----
    database_port: null
    database_name: todolist <----
    database_user: root <----
    database_password: root <----
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: null
    mailer_password: null
    secret: ThisTokenIsNotSoSecretChangeIt
-----------------------------------------------------------------

parameters:
    database_host: IP VOTRE BASE DE DONNEES <----
    database_port: null
    database_name: NOM DE LA BASE DE DONNEES<----
    database_user: UTILISATEUR DE VOTRE BASE DE DONNEES <----
    database_password: MOT DE PASSE DE L'UTILISATEUR <----
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: null
    mailer_password: null
    secret: ThisTokenIsNotSoSecretChangeIt

```

Placez vous dans le dossier TodoList et initialisez la base de donnée en faisant un :
```
$ composer initBD
```
 
## Lancement du projet

Placez vous dans le dossier public :
```
$ cd web
```

Puis lancer votre serveur php par la commande :
```
$ php -S localhost:8000 -ddisplay_errors=1
```
*Vous pouvez maintenant effectuer toutes les requètes que vous souhaitez vers l'API*
## Développé avec

* **Symfony 3.1.10** 
* **PHP 7.1.3**
* **Mysql 14.14**
* **Composer 1.8.5** 

## Versioning

Le versioning du projet a été effectué avec git version 2.7.4 , pour chaque étape du développement une branche a 
été créé et finalisé par un Pullrequest.

## Auteur

**Bouvier Jérémy** - Étudiant à Openclassrooms 
 Parcours suivi *Développeur d'application PHP/Symfony*
 
## Code Reviewer

**Boileau Thomas** - Mentor à Openclassrooms 

## Licence

Pas de licence enregistrée.
