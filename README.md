TP 06/02 - Création d'un API
Objectifs
• Créer une API avec Symfony et API Platform
• Créer une interface utilisateur avec React et React Router
Consignes
• Suivez le guide à l'apprentissage pour créer l'API Doctomap : https://symfony.agiliteach.fr/#/api-platform
• Ajoutez une image de profil pour tous les médecins
• Créez une interface utilisateur avec React et React Router pour consommer l'API Doctomap
• Sécurisez l'API pour qu'elle ne puisse être appelée que par votre interface utilisateur
Ressources
• Symfony
• API Platform
• React
• React Router


Liste Etapes : 
- symfony new doctomap
- composer require symfony/maker-bundle --dev
- composer require symfony/orm-pack
- Dans .env, commenté la ligne concernant le BDD Postgre et décommenté DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
- symfony console d:d:c
- symfony console make:entity Doctor
- Entité Doctor : 
Nom	         Type	       Détail	         Nullable
firstname	  string	  50caractères	       Non
lastname	  string	  50 caractères	       Non
speciality	string	  50 caractères	       Non
address	    string	 255 caractères	       Non
city	      string	  50 caractères	       Non
zip	        string	   5 caractères	       Non
phone	      string	  12 caractères	       Oui
- symfony console make:migration
- symfony console d:m:m
- symfony composer require api
- composer require orm-fixtures --dev
- composer require fakerphp/faker
- symfony console d:f:l