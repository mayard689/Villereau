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
                $faker->randomElement(["Les", "Association des", "Fondation pour les"]).
                $adjectif.
                $faker->randomElement(["joueur", "fleuriste", "tireurs", "fêtards", "gymnastes"])
            );
            $card->setEmail($adjectif.$faker->email);
            $card->setPhone($faker->phoneNumber);
            $card->setText($faker->text(125));
            $card->setRole("Loisir");
            $card->setType("Association");
            $card->setPicture('fixture_assoc_card_'.rand(1,6).'.jpeg');

            $manager->persist($card);
        }

        for ( $i=0; $i<self::ADMIN_NUMBER; $i++) {
            $adjectif = $faker->randomElement(["pirate", "ripoux", "social", "communiste", "neutre"]);
            $card = new Vcard();
            $card->setName(
                $faker->randomElement(["Centre de", "Fond de", "Comité d'action de", "Bureau de"]).
                $faker->randomElement(["maires", "perception", "l'urbanisme", "l'état civil", "médecine"]).
                $adjectif

            );
            $card->setEmail($adjectif."@email.fr");
            $card->setPhone($faker->phoneNumber);
            $card->setText($faker->text(125));
            $card->setRole($adjectif);
            $card->setType("Administratif");
            $card->setPicture('fixture_admin_card_'.rand(1,4).'.jpeg');

            $manager->persist($card);
        }

        $manager->flush();
    }
}
