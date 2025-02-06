<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\DoctorRepository;
use App\Entity\Doctor;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
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
}
