<?php

namespace App\DataFixtures;

use App\Entity\Content;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ContentFixtures extends Fixture implements DependentFixtureInterface
{
    const CONTENT_NUMBER=20;

    const CONTENT = [
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i=0; $i<self::CONTENT_NUMBER; $i++){

            $content = new Content();

            if ($i < count(self::CONTENT)) {
                $content->setTitle(self::CONTENT[$i]['title']);
                $content->setText(self::CONTENT[$i]['text']);
                $content->setWriter('Anonym');
                $content->setPicture(self::CONTENT[$i]['picture']);
            } else {
                $content->setTitle($faker->sentence);
                $content->setText($faker->text(1000));
                $content->setWriter('Anonym');
                $content->setPicture('fixture_content-'.rand(1,7).'.jpg');

                $categoryIndex = rand(0 , CategoryFixtures::CATEGORY_NUMBER-1);
                $category = $this->getReference('category_'.$categoryIndex);
                $content->setCategory($category);
            }

            $content->setDate($faker->dateTimeBetween('-3 months', '2021/06/31'));

            $this->addReference('content_' .$i, $content);
            $manager->persist($content);
        }
        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}
