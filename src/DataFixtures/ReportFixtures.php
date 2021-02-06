<?php

namespace App\DataFixtures;

use App\Entity\Report;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReportFixtures extends Fixture
{
    const REPORT_NUMBER=24;

    const REPORT = [
      0 => [
          'document' => 'report-1.pdf',
      ],
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');


        for($i=0; $i<self::REPORT_NUMBER; $i++){

            $report = new Report();

            if ($i < count(self::REPORT)) {
                $report->setDocument(self::REPORT[$i]['document']);
            } else {
                $report->setDocument('fixture_report-'.rand(1,2).'.pdf');
            }

            $report->setDate($faker->dateTimeThisYear($max = 'now'));

            $this->addReference('report_' .$i, $report);

            $manager->persist($report);
        }
        $manager->flush();
    }

}
