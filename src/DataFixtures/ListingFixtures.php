<?php

namespace App\DataFixtures;

use App\Entity\Listing;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ListingFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $listing = new Listing();
        $this->addReference('listing', $listing);
        $manager->persist($listing);
        $manager->flush();
    }
}
