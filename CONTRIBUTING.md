# Contributing

Tout d'abord, merci de votre intéret et de votre contribution au projet ToDoList. Lorsque vous contribuez au 
développement de ToDoList, veuillez tout d’abord discuter des changements à apporter avec les mainteneurs du 
projet avant de faire tout changement. Veuillez les contacter par email ou toute autre méthode signalée dans le 
README.md.

## Procédure de versioning GIT

Tout ajout ou modification de fonctionnalité au projet doit faire l'objet d'une création de branche ainsi que la mise 
en place d'une PullRequest. Chaque réalisation de Pullrequest devra respecter les points suivants: 

1. Assurer vous d'avoir toutes les mis à jour des dépendances du projet avant d'entamer une PullRequest.
2. Mettre à jour le fichier README.md en y spécifiant toutes les modifications que vous avez apportées au projet, 
   merci d'actualiser la version du projet sur le fichier README.md correspondant à votre Pullrequest.
3. Vous ne pouvez merger votre Pullrequest qu'après avoir eu l'autorisation des mainteneurs du projet ou par 
   l'intermédiaire d'un code reviewer.
   
## Coding style

Tout ajouts ou modifications de code dans le projet doivent se faire en respectant les spécifications du PSR12 préconisé
par le PHPFIG. Le PSR12 énumère un ensemble de règles et d'attentes partagées concernant la mise en forme du code PHP. 
Ce PSR cherche à fournir un moyen d'améliorer l'interopérabilité des projets, mais permet aussi de faciliter la 
collaboration de plusieurs developpeurs sur un même projet.

## Processus de developpement

Lors du développement de nouvelles fonctionnalités, vous devrez respecter le processus de développement suivant :

- Réalisez votre fonctionnalité en veillant à respecter la procédure de versioning précisée dans ce document.
- Effectuez les tests automatisés afin de contrôler que vos modifications n'impactent pas le bon fonctiionnement de
l'application. Réaliser ensuite les tests associés à votre nouvelle fonstionnalité.
- Effectuez les tests de performance avant et après ajout de votre fonctionnalité afin de contrôler que les 
modifications que vous avez apportées n'influence pas les performances de l'application.

