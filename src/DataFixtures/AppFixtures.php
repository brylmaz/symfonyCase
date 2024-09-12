<?php

namespace App\DataFixtures;

use App\Entity\Developers;
use Couchbase\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $developers = [
            ['name' => 'DEV1', 'speed' => 1],
            ['name' => 'DEV2', 'speed' => 2],
            ['name' => 'DEV3', 'speed' => 3],
            ['name' => 'DEV4', 'speed' => 4],
            ['name' => 'DEV5', 'speed' => 5],
        ];

        foreach ($developers as $developer) {
            $developerEntity = new Developers();
            $developerEntity->setName($developer['name']);
            $developerEntity->setDegree($developer['speed']);
            $developerEntity->setStatus(true);
            $manager->persist($developerEntity);
        }

        $manager->flush();
    }
}
