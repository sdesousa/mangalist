<?php

namespace App\DataFixtures;

use App\Entity\MangaAuthor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class MangaAuthorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 400; $i++) {
            $manga = $this->getReference('manga_' . $i);
            $nbAuthors = rand(0, 100) < 80 ? 1 : rand(2, 3);
            for ($j = 0; $j < $nbAuthors; $j++) {
                $mangaAuthor = new MangaAuthor();
                $mangaAuthor->setManga($manga);
                $mangaAuthor->setAuthor($this->getReference('author_' . rand(0, 99)));
                $mangaAuthor->setRole($this->getReference('authorRole_' . rand(0, 3)));
                $manager->persist($mangaAuthor);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AuthorFixtures::class,
            AuthorRoleFixtures::class,
            MangaFixtures::class
        ];
    }
}
