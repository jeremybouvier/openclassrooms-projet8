# Contributing

Tout d'abord, merci de votre intéret et de votre contribution au projet ToDoList. Lorsque vous contribuez au 
développement de ToDoList, veuillez tout d’abord discuter des changements à apporter avec les mainteneurs du 
projet avant de faire tout changement. Veuillez les contacter par email ou toute autre méthode signalée dans le 
README.md.

## Procédure de versioning GIT

Tout ajout ou modification de fonctionnalité au projet doit faire l'objet d'une création de branche ainsi que la mise 
en place d'une PullRequest. Chaque réalisation de Pullrequest devra respecter les points suivants: 

1. Assurer vous d'avoir toutes les mis à jour des dépendances du projet avant d'entamer une PullRequest en faisant :
    ```
    $ composer update
    ```

2. Mettre à jour le fichier README.md en y spécifiant toutes les modifications que vous avez apportées au projet, 
   merci d'actualiser la version du projet sur le fichier README.md correspondant à votre Pullrequest.
   
3. Vous ne pouvez merger votre Pullrequest qu'après avoir eu l'autorisation des mainteneurs du projet ou par 
   l'intermédiaire d'un code reviewer.
   
4. Veuillez à respecter la procedure suivante lors de la réalisation ou la mofidification de fonctionnalité :
   
   #####Clonage de la branche principale 
   
   Commencez par télécharger le projet comme décrit dans le document README.md [README.md](/README.md)
   
   ```
     $ git clone https://github.com/jeremybouvier/openclassrooms-projet8 TodoList
   ```
   
   #####Ajout d'une branche ou récupération d'une branche existante
   
   Avant de commencer tout développement ajoutez une nouvelle branche et basculer dessus par la commande si vous 
   souhaitez commencer une nouvelle branche:
   
    ```
      $ git checkout -b nom_de_ma_branch_nouvelle
    ```
   
   Dans le cas où vous vouliez modifier une nouvelle branche utilisez la commande :
   
     ```
       $ git checkout -b nom_de_ma_branch_nouvelle
     ```
   
   #####Réalisation d'un commit
   
   A chaque étape de votre développement n'hesitez pas à réaliser des commits par la commande  
    ```
      $ git add chemin_vers_mon_fichier
      $ git commit -m "message du commit"
    ```
   
   #####Envoyer les commits sur la nouvelle branche du repository Github 
   
   ```
     $ git push origin nom_de_ma_branch_nouvelle
   ```
   
   #####Réaliser une Pullrequest 
   Créer une Pullrequest par la commande :
   ```
    $ git request-pull origin nom_de_ma_branch_nouvelle
   ```
   ou allez sur le repository Github https://github.com/jeremybouvier/openclassrooms-projet8
   et créez une pullrequest depuis la nouvelle branche que vous avez créer.
   
   #####Fusion de la branche sur le projet principal
   Une fois que les mainteneurs de l'application vous ont donné l'autorisation vous pourrez alors mergé votre 
   Pullrequest sur le branch master.  
   
   
## Coding style

Tout ajouts ou modifications de code dans le projet doivent se faire en respectant les spécifications du PSR12 préconisé
 par le PHPFIG. Le PSR12 énumère un ensemble de règles et d'attentes partagées concernant la mise en forme du code PHP. 
Ce PSR cherche à fournir un moyen d'améliorer l'inter-opérabilité des projets, mais permet aussi de faciliter la 
collaboration de plusieurs développeurs sur un même projet. De plus votre code doit respecter les bonnes pratiques de 
codage en vigueur. 

## Processus de developpement 

Lors du développement de nouvelles fonctionnalités, vous devrez respecter le processus de développement suivant :

1- A chaque étape de développement de votre fonctionnalité veuillez respecter la procédure de versioning précisée dans 
   ce document. Votre code doit respecter le PSR12 et les bonnes pratiques de codage en vigueur, pour ce faire vous 
   devez utiliser les outils PHP Code Sniffer, Metrix et Sonar Scanner.
   
   Afin de contrôler le code styling de vos modifications lancer une analyse PHP Code Sniffer par la commande : 

   ```
     $ ./vendor/bin/phpcs
   ```
   Ensuite Contôlez la qualité de votre code en faisant une analyse avec Metrix :
   
   ```
      $ ./vendor/bin/phpmetrics
   ```
   Et une analyse Sonar Scanner:
   ```
     $ ./sonar-scanner-4.0.0.1744-linux/bin/sonar-scanner -X
   ```
    
   
2- Effectuez les tests automatisés afin de contrôler que vos modifications n'impactent pas le bon fonctionnement de
   l'application. Pour lancer les tests automatisés exécutez la commande :
   ```
     $ ./vendor/bin/simple-phpunit --coverage-hmtl /dossier_où_vous_souhaitez_enregistrer_le_rapport_de_couverture
   ```
   Réaliser ensuite les tests associés à votre nouvelle fonctionnalité et placez-les dans le dossier tests présent 
   dans le projet.

3- Effectuez les tests de performance avant et après ajout de votre fonctionnalité afin de contrôler que les 
   modifications que vous avez apportées n'influence pas les performances de l'application. Pour ce faire il est 
   conseillé d'utiliser Blackfire pour effectuer les tests de performance. 

