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
image       string   255 caractères        Non
- symfony console make:migration
- symfony console d:m:m
- symfony composer require api
- Dans l'entité Doctor, rajouté l'annotation : #[ApiResource] à la class et importer cette class ApiResource
- lancer le serveur et aller sur la route /api pour voir toutes les routes de notre api
- composer require orm-fixtures --dev
- composer require fakerphp/faker
- Coder dans AppFixtures : 
  - Rajouter les classes : 
      - use ApiPlatform\Metadata\ApiResource;
      - use App\Repository\DoctorRepository;
      - use App\Entity\Doctor;
      - use Faker\Factory;
  - Modifier la fonction load par :  
      - public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 30; $i++) {
            $doctor = new Doctor();
            $doctor->setFirstname($faker->firstName());
            $doctor->setLastname($faker->lastName());
            $doctor->setSpeciality($faker->jobTitle());
            $doctor->setAddress($faker->streetAddress());
            $doctor->setCity($faker->city());
            $doctor->setZip($faker->postcode());
            $doctor->setPhone($faker->phoneNumber());
            $doctor->setImage('https://avatar.iran.liara.run/public/' . $i);

            $manager->persist($doctor);
        }

        $manager->flush();
    }
- symfony console d:f:l