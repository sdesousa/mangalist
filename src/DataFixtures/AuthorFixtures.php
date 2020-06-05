<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('jp_JP');
        for ($i = 0; $i < 100; $i++) {
            $author = new Author();
            if (rand(0, 100) < 90) {
                $author->setFirstname($faker->firstName);
                $author->setLastname($faker->lastName);
            } else {
                $author->setPenname($faker->word);
            }
            $this->addReference('author_' . $i, $author);
            $manager->persist($author);
        }
        $manager->flush();
    }
}
