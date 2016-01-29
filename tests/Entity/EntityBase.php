<?php

namespace AudioCoreEntity\Tests;

use AudioCoreEntity\Entity\Album;
use AudioCoreEntity\Entity\Artist;
use AudioCoreEntity\Entity\Genre;
use AudioCoreEntity\Entity\Media;

abstract class EntityBase extends \PHPUnit_Framework_TestCase
{

    /**
     * @return Genre
     */
    static public function getGenreInstance()
    {
        return new Genre();
    }

    static public function getMediaInstance()
    {
        return new Media();
    }

    static public function getArtistInstance()
    {
        return new Artist();
    }

    static public function getAlbumInstance()
    {
        return new Album();
    }
}