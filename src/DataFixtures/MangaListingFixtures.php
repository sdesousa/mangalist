<?php

namespace App\DataFixtures;

use App\Entity\Manga;
use App\Entity\MangaListing;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class MangaListingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 300; $i++) {
            $mangaListing = new MangaListing();
            $manga = $this->getReference('manga_' . rand(0, 399));
            $mangaListing->setListing($this->getReference('listing'));
            $mangaListing->setManga($manga);
            $mangaListing->setPossessedVolume(rand(0, $manga->getTotalVolume()));
            $mangaListing->setRemark($faker->sentence(8));
            $manager->persist($mangaListing);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ListingFixtures::class,
            MangaFixtures::class
        ];
    }
}
