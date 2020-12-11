<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends Fixture
{
    const CATEGORY_NUMBER=5;

    const CATEGORIES = [
      0 => [
          'name' => 'Associations',
      ],
        1 => [
            'name' => 'Cimetière',
        ],
        2 => [
            'name' => 'Vie pratique',
        ],
        3 => [
            'name' => 'Ecole',
        ],
        4 => [
            'name' => 'Equipement',
        ],
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i=0; $i<self::CATEGORY_NUMBER; $i++){

            $category = new Category();

            if ($i < count(self::CATEGORIES)) {
                $category->setName(self::CATEGORIES[$i]['name']);
            } else {
                $category->setName($faker->word);
            }

            $this->addReference('category_' .$i, $category);

            $manager->persist($category);
        }
        $manager->flush();
    }

}
