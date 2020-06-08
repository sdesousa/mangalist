<?php

namespace App\DataFixtures;

use App\Entity\AuthorRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AuthorRoleFixtures extends Fixture
{
    private const ROLES = [
        'Auteur',
        'Scenariste',
        'Dessinateur',
        'Consultant',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::ROLES as $key => $role) {
            $authorRole = new AuthorRole();
            $authorRole->setRole($role);
            $this->addReference('authorRole_' . $key, $authorRole);
            $manager->persist($authorRole);
        }
        $manager->flush();
    }
}
