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
          'title' => 'Gagner de l\'argent, Sauver la planète, prendre un bain.',
          'text' => 'Vous êtes dans votre baignoire, musique relaxante, mousse senteur des îles, eau tiède ou chaude, 
                  comme vous aimez. Oublié les ennuis du boulot, et le dérèglement climatique et les enfants qui courent partout, 
                  c’est le temps d’un instant pour soi, allégé par la poussé d’Archimède bref, relaxation, décontraction, 
                  déconnexion.

                  Mais c’est là qu’arrive le “Un bain ! Ça consomme trop ! Trop d’électricité pour chauffer toute cette eau perdue. La 
                  douche c’est plus économique”. Mais tout dépend de la durée de la douche, vous ne croyez pas ?
                    
                  Auriez vous imaginé qu’au delà de 7 minutes, une douche consomme plus d’eau et de chauffage qu’un bain de 30 minutes. Chaque minute sous l’eau 
                  chaude coûte environ 27 euros par an, 54€ si vous êtes deux...Vous pourriez tout autant vous offrir un dîner aux 
                  chandelles et trouver un endroit au calme pour admirer les étoiles.
                    
                  On est bien d’accord : personne n’a envie de se retrouver dans un dîner en tête à tête avec les cheveux gras à cause 
                  d’une toilette expédiée. 
                    
                  L’idée c’est juste que si, comme beaucoup de français vous passez 9 minutes sous la douche, vous pouvez sans doute 
                  diminuer à 8 minutes et prendre un bon bain bien long de temps en temps. Prenez soin de vous et prenez du temps pour 
                  vous.',
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
