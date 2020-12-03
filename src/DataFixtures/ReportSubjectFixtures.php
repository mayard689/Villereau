<?php

namespace App\DataFixtures;

use App\Entity\ReportSubject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ReportSubjectFixtures extends Fixture implements DependentFixtureInterface
{
    const REPORT_SUBJECT_NUMBER=24;

    const REPORT = [
      0 => [
          'title' => 'Premier sujet à l\'ordre du jour',
      ],
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');


        for($i=0; $i<self::REPORT_SUBJECT_NUMBER; $i++){

            $reportSubject = new ReportSubject();

            if ($i < count(self::REPORT)) {
                $reportSubject->setTitle(self::REPORT[$i]['title']);
            } else {
                $reportSubject->setTitle($faker->sentence);
            }

            $reportIndex = rand(0 , ReportFixtures::REPORT_NUMBER-1);
            $report = $this->getReference('report_'.$reportIndex);
            $reportSubject->setReport($report);

            $manager->persist($reportSubject);
        }
        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [ReportFixtures::class];
    }

}
