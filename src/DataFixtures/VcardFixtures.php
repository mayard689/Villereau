<?php

namespace App\DataFixtures;

use App\Entity\Vcard;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class VcardFixtures extends Fixture
{
    const ENTERPRISE_NUMBER = 15;
    const ASSOC_NUMBER = 5;
    const ADMIN_NUMBER = 5;

    public function __construct()
    {
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ( $i=0; $i<self::ENTERPRISE_NUMBER; $i++) {
            $card = new Vcard();
            $card->setName($faker->company);
            $card->setEmail($faker->email);
            $card->setPhone($faker->phoneNumber);
            $card->setText($faker->text(125));
            $card->setRole($faker->jobTitle);
            $card->setType("Entreprise");
            $card->setPicture('fixture_entr_card_'.rand(1,4).'.jpeg');

            $manager->persist($card);
        }

        for ( $i=0; $i<self::ASSOC_NUMBER; $i++) {

            $adjectif = $faker->randomElement(["joyeux", "peureux", "fiers", "beaux", "sexy"]);
            $card = new Vcard();
            $card->setName(
                $faker->randomElement(["Les", "Association des", "Fondation pour les"])." ".
                $adjectif." ".
                $faker->randomElement(["joueurs", "fleuristes", "tireurs", "fêtards", "gymnastes"])
            );
            $card->setEmail($adjectif.$faker->email);
            $card->setPhone($faker->phoneNumber);
            $card->setText($faker->text(125));
            $card->setRole("Loisir");
            $card->setType("Association");
            $card->setPicture('fixture_assoc_card_'.rand(1,4).'.jpeg');

            $manager->persist($card);
        }

        for ( $i=0; $i<self::ADMIN_NUMBER; $i++) {
            $adjectif = $faker->randomElement(["pirates", "ripoux", "sociaux", "gilets jaunes", "neutres"]);
            $card = new Vcard();
            $card->setName(
                $faker->randomElement(["Centre des", "Fond des", "Comité d'action des", "Bureau des"])." ".
                $faker->randomElement(["maires", "perceptions", "urbanismes", "états civils", "médecines"])." ".
                $adjectif

            );
            $card->setEmail($adjectif."@email.fr");
            $card->setPhone($faker->phoneNumber);
            $card->setText($faker->text(125));
            $card->setRole($adjectif);
            $card->setType("Service Administratif");
            $card->setPicture('fixture_admin_card_'.rand(1,4).'.jpeg');

            $manager->persist($card);
        }

        $manager->flush();
    }
}
