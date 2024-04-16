<?php

namespace App\DataFixtures;

use App\Factory\BonusFactory;
use App\Factory\CustomerFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        CustomerFactory::createMany(100, function () {
            return [
                'isBirthday' => null,
                'isEmailVerified' => null,
                'roles' => ['ROLE_USER'],
            ];
        });

        BonusFactory::createMany(100, function () use ($faker) {
            return [
                'name' => $faker->text(15),
                'reward_id' => random_int(1, 2),
            ];
        });
    }
}
