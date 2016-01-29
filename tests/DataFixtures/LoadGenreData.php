<?php

namespace AudioCoreEntity\Tests\DataFixtures;


use AudioCoreEntity\Entity\Genre;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGenreData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $genre = new Genre();
        $genre->setName('Pop');
        $manager->persist($genre);
        $manager->flush();
    }
}