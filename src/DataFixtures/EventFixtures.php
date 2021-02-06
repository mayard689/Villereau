<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EventFixtures extends Fixture
{
    const EVENT_NUMBER=30;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i=0; $i<self::EVENT_NUMBER; $i++){
            $city=$faker->city;

            $event = new Event();
            $event->setName($faker->colorName);
            $event->setText($faker->paragraph(10, true));
            $event->setDate($faker->dateTimeBetween('-1 years', '2021/12/31'));
            $event->setPlace($city);
            $event->setPicture('fixture_event-'.rand(1,5).'.jpg');
            //$event->setPictureSize(100);
            $this->addReference('event_' .$i, $event);
            $manager->persist($event);
        }
        $manager->flush();

    }
}
