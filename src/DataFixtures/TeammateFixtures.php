<?php

namespace App\DataFixtures;

use App\Entity\Teammate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TeammateFixtures extends Fixture
{
    const TEAMMATE = [
        0 => [
            'firstname' => 'Adrien',
            'lastname' => 'MAILLARD',
            'role' => 'Conseiller Municipal',
            'type' => 'Conseiller'
        ],
        1 => [
            'firstname' => 'Adrien',
            'lastname' => 'MAILLARD',
            'role' => 'Conseiller Municipal',
            'type' => 'Conseiller'
        ],
        2 => [
            'firstname' => 'Adrien',
            'lastname' => 'MAILLARD',
            'role' => 'Conseiller Municipal',
            'type' => 'Conseiller'
        ],
        3 => [
            'firstname' => 'Adrien',
            'lastname' => 'MAILLARD',
            'role' => 'Conseiller Municipal',
            'type' => 'Conseiller'
        ],
        4 => [
            'firstname' => 'Adrien',
            'lastname' => 'MAILLARD',
            'role' => 'Conseiller Municipal',
            'type' => 'Conseiller'
        ],
        5 => [
            'firstname' => 'Adrien',
            'lastname' => 'MAILLARD',
            'role' => 'Conseiller Municipal',
            'type' => 'Conseiller'
        ],
        6 => [
            'firstname' => 'Adrien',
            'lastname' => 'MAILLARD',
            'role' => 'Conseiller Municipal',
            'type' => 'Conseiller'
        ],
        7 => [
            'firstname' => 'Adrien',
            'lastname' => 'MAILLARD',
            'role' => 'Conseiller Municipal',
            'type' => 'Conseiller'
        ],
        8 => [
            'firstname' => 'Simone',
            'lastname' => 'HERVOUET',
            'role' => 'Premier Adjoint',
            'type' => 'Adjoint'
        ],
        9 => [
            'firstname' => 'Maxence',
            'lastname' => 'LEVEQUE',
            'role' => 'Second Adjoint',
            'type' => 'Adjoint'
        ],
        10 => [
            'firstname' => 'Bertrand',
            'lastname' => 'BRIE',
            'role' => 'Maire',
            'type' => 'Maire'
        ],
        11 => [
            'firstname' => 'Annabelle',
            'lastname' => 'ALMEIDA',
            'role' => 'Secrétaire Générale',
            'type' => 'Secrétaire Général'
        ],
        12 => [
            'firstname' => 'Steven',
            'lastname' => 'FOURREAU',
            'role' => 'Agent Communal',
            'type' => 'Agent'
        ],
        13 => [
            'firstname' => 'Dominique',
            'lastname' => 'COUTANT',
            'role' => 'Agent Communal',
            'type' => 'Agent'
        ],
    ];


    public function __construct()
    {
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        foreach (self::TEAMMATE as $teammate) {
            $mate = new Teammate();
            $mate->setFirstname($teammate['firstname']);
            $mate->setLastname($teammate['lastname']);
            $mate->setText($faker->text(500));
            $mate->setRole($teammate['role']);
            $mate->setType($teammate['type']);
            $mate->setPicture('fixture_mate_'.rand(1,6).'.jpeg');

            $manager->persist($mate);
        }

        $manager->flush();
    }
}
