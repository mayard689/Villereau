<?php

namespace App\DataFixtures;

use App\Entity\Content;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ContentFixtures extends Fixture
{
    const CONTENT_NUMBER=20;

    const CONTENT = [
      0 => [
          'title' => 'Ceci est un exemple de titre.',
          'text' => 'Ceci est un exemple de texte.',
          'picture' => 'douche.jpeg',
      ],
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i=0; $i<self::CONTENT_NUMBER; $i++){

            $content = new Content();

            if ($i < count(self::CONTENT)) {
                $content->setTitle(self::CONTENT[$i]['title']);
                $content->setText(self::CONTENT[$i]['text']);
                $content->setPicture(self::CONTENT[$i]['picture']);
            } else {
                $content->setTitle($faker->sentence);
                $content->setText($faker->text);
                $content->setPicture('content-'.rand(1,3).'.png');
            }


            $content->setDate($faker->dateTimeBetween('-3 months', '2021/06/31'));

            $this->addReference('content_' .$i, $content);
            $manager->persist($content);
        }
        $manager->flush();
    }

}
