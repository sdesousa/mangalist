<?php

namespace App\DataFixtures;

use App\Entity\Editor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class EditorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $editor = new Editor();
            $editor->setName($faker->sentence(2));
            $this->addReference('editor_' . $i, $editor);
            $manager->persist($editor);
        }
        $manager->flush();
    }
}
