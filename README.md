# TP 06/02 - Création d'une API

## Objectifs
- Créer une API avec Symfony et API Platform
- Créer une interface utilisateur avec React et React Router

## Consignes
- Suivez le guide à l'apprentissage pour créer l'API Doctomap : [Symfony API Platform Guide](https://symfony.agiliteach.fr/#/api-platform)
- Ajoutez une image de profil pour tous les médecins
- Créez une interface utilisateur avec React et React Router pour consommer l'API Doctomap
- Sécurisez l'API pour qu'elle ne puisse être appelée que par votre interface utilisateur

## Ressources
- Symfony
- API Platform
- React
- React Router

---

## Liste des étapes

### 1. Installation et configuration de Symfony
```sh
symfony new doctomap
composer require symfony/maker-bundle --dev
composer require symfony/orm-pack
```
- Dans `.env`, commenter la ligne concernant la BDD PostgreSQL et décommenter :
  ```
  DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
  ```
```sh
symfony console d:d:c
```

### 2. Création de l'entité `Doctor`
```sh
symfony console make:entity Doctor
```
| Nom        | Type    | Détail            | Nullable |
|------------|--------|------------------|----------|
| firstname  | string | 50 caractères    | Non      |
| lastname   | string | 50 caractères    | Non      |
| speciality | string | 50 caractères    | Non      |
| address    | string | 255 caractères   | Non      |
| city       | string | 50 caractères    | Non      |
| zip        | string | 5 caractères     | Non      |
| phone      | string | 12 caractères    | Oui      |
| image      | string | 255 caractères   | Non      |

```sh
symfony console make:migration
symfony console d:m:m
```

### 3. Installation et configuration de l'API
```sh
composer require api
```
- Dans l'entité `Doctor`, ajouter l'annotation :
  ```php
  #[ApiResource]
  ```
- Importer la classe `ApiResource`.

- Lancer le serveur et vérifier les routes API :
```sh
symfony serve
```
Accéder à `/api` pour voir les routes disponibles.

### 4. Ajout de fixtures
```sh
composer require orm-fixtures --dev
composer require fakerphp/faker
```
- Modifier `AppFixtures.php` :
  ```php
    use Doctrine\Bundle\FixturesBundle\Fixture;
    use Doctrine\Persistence\ObjectManager;
    use ApiPlatform\Metadata\ApiResource;
    use App\Repository\DoctorRepository;
    use App\Entity\Doctor;
    use Faker\Factory;

  public function load(ObjectManager $manager)
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
  ```
```sh
symfony console d:f:l -n
```
- Relancer le serveur :
```sh
symfony serve
```
- Lancer la commande pour sécuriser l'api avec cors :
```sh
composer require nelmio/cors-bundle
```
- Modifier `.env` :
```CORS_ALLOW_ORIGIN='http://localhost:5173'
```
- Modifier `nelmio_cors.yaml` :
```nelmio_cors:
    defaults:
        origin_regex: true
        allow_methods: ['GET'] # Par défaut, toutes les routes auront uniquement la méthode GET.
        allow_headers: ['Content-Type', 'Authorization']
        expose_headers: ['Link']
        max_age: 3600
    paths:
        '^/': 
            allow_origin: ['%env(CORS_ALLOW_ORIGIN)%']
            allow_methods: ['GET', 'POST', 'PUT', 'PATCH', 'DELETE']  # Autorisation de toutes les méthodes
            allow_headers: ['Content-Type', 'Authorization']
            expose_headers: ['Link']
            max_age: 3600
```