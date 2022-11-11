<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    /**
     * Undocumented variable
     *
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {

        for ($i=1; $i <= 50 ; $i++) { 
            $user = new User();
            $user->setUsername($this->faker->userAgent())
                ->setAdress('Lot IVP 144 Ankadifotsy')
                ->setEmail('vinaandrianarisoa1@gmail.com');
            
            $manager->persist($user);
        }

        $manager->flush();
    }
}
