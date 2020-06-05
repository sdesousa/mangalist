<?php

namespace App\DataFixtures;

use App\Entity\EditorCollection;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class EditorCollectionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $editor = $this->getReference('editor_' . $i);
            $nbCollection = rand(2, 5);
            for ($j = 0; $j < $nbCollection; $j++) {
                $editorCollection = new EditorCollection();
                $editorCollection->setName($faker->word);
                $editorCollection->setEditor($editor);
                $manager->persist($editorCollection);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [EditorFixtures::class];
    }
}
