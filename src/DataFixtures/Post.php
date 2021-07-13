<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class Post extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i =0;$i<20;$i++){
            $post = new \App\Entity\Post();

            $post->setDescription($faker->sentence);
            $post->setDate($faker->dateTime);
            $user=$i % 20;
            $post->setOwner($this->getReference("user$user"));
            $manager->persist($post);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            Userfixtures::class
        ];
    }
}
