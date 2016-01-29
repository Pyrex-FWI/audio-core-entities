<?php

namespace AudioCoreEntity\Tests\Entity;


use AudioCoreEntity\Tests\EntityBase;
use Doctrine\Common\Collections\ArrayCollection;

class MediaTest extends EntityBase
{

    public function  testMediaMethods()
    {
        $media = self::getMediaInstance();
        $genre = self::getGenreInstance('Genre');
        $addGenre = self::getGenreInstance('Additional genre');
        $artist = self::getArtistInstance('artist');
        $addArtist = self::getArtistInstance('Additional artist');

        $md5 = md5('md5');
        $media
            ->setProvider(1)
            ->setArtist('ArtistName')
            ->setTitle('Title')
            ->setGenres(new ArrayCollection([$genre]))
            ->setBpm(120)
            ->setDeletedAt(new \DateTime('now'))
            ->setDirName('DirName')
            ->setFileName('FileName')
            ->setFullFilePathMd5($md5)
            ->setFullPath(__DIR__)
            ->setReleaseDate(new \DateTime('now'))
            ->setProviderUrl('http://www.se.dom')
            ->setScore(3)
            ->setTagged(true)
            ->setType(2)
            ->setYear(2000)
            ->setVersion('Explicit')
            ->setProviderId('XXXX')
            ->addGenre($addGenre)
            ->removeGenre($addGenre)
            ->addArtist($addArtist)
            ->removeArtist($addArtist)
            ->setArtists(new ArrayCollection([$artist]))
            ->setExist(false)
        ;

        $this->assertEquals($media->getArtist(), 'ArtistName');
        $this->assertEquals($media->getTitle(), 'Title');
        $this->assertEquals($media->getGenres()->get(0), $genre);
        $this->assertEquals($media->getArtists()->get(0), $artist);
        $this->assertEquals($media->getBpm(), 120);
        $this->assertEquals(get_class($media->getDeletedAt()), 'DateTime');
        $this->assertEquals(get_class($media->getReleaseDate()), 'DateTime');
        $this->assertEquals($media->getExist(), false);
        $this->assertEquals($media->getFileName(), 'Entity');
        $this->assertEquals($media->getFullFilePathMd5(), md5(__DIR__));
        $this->assertEquals($media->getFullPath(), __DIR__);
        $this->assertEquals($media->getProviderUrl(), 'http://www.se.dom');
        $this->assertEquals($media->getScore(), 3);
        $this->assertEquals($media->getProviderId(), 'XXXX');
        $this->assertEquals($media->getVersion(), 'Explicit');
        $this->assertEquals($media->getProviderCode(), 'ddp');
        $this->assertEquals($media->getDirName(), 'tests');
        $media->getId();
        $this->assertEquals($media->getType(), 2);

    }


    public function testWrongBpm()
    {
        $this->assertNull(self::getMediaInstance()->setBpm(-100.67)->getBpm());
        $this->assertEquals(self::getMediaInstance()->setBpm(+100.67)->getBpm(), 100.67);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWrongType()
    {
        self::getMediaInstance()->setType(100);
    }

    public function testTypes()
    {
        $this->assertArrayHasKey('audio', self::getMediaInstance()->getTypes());
        $this->assertArrayHasKey('video', self::getMediaInstance()->getTypes());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWrongProvider()
    {
        self::getMediaInstance()->setProvider(100);
    }

    public function testProviders()
    {
        $this->assertArrayHasKey('av_district', self::getMediaInstance()->getProviders());
        $this->assertArrayHasKey('frp_video', self::getMediaInstance()->getProviders());
        $this->assertArrayHasKey('frp_audio', self::getMediaInstance()->getProviders());
        $this->assertArrayHasKey('ddp', self::getMediaInstance()->getProviders());
        $this->assertArrayHasKey('sv', self::getMediaInstance()->getProviders());
    }

    public function testWrongProviderUrl()
    {
        $this->assertNull(self::getMediaInstance()->setProviderUrl('toto')->getProviderUrl());
    }

    public function testWrongYear()
    {
        $this->assertNull(self::getMediaInstance()->setYear('toto')->getYear());
    }
}
