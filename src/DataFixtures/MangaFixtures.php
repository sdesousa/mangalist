<?php

namespace App\DataFixtures;

use App\Entity\Manga;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class MangaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 400; $i++) {
            $manga = new Manga();
            $editor = $this->getReference('editor_' . rand(0, 9));
            $editorCollections = $editor->getEditorCollections();
            $editorCollection = $editorCollections[array_rand($editorCollections->toArray())];
            $manga->setTitle($faker->sentence(3));
            (rand(0, 100) < 70) ?: $manga->setTotalVolume(rand(1, 120));
            $manga->setYear(rand(1950, 2020));
            $manga->setEditor($editor);
            $manga->setEditorCollection($editorCollection);
            (rand(0, 100) < 70) ?: $manga->setAvailableVolume(rand(0, $manga->getTotalVolume()));
            (rand(0, 100) < 80) ?: $manga->setRemark($faker->sentence(8));
            $this->addReference('manga_' . $i, $manga);
            $manager->persist($manga);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [EditorFixtures::class];
    }
}
