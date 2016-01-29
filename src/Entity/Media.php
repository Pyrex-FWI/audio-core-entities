<?php

namespace AudioCoreEntity\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use DeejayPoolBundle\Entity\AvdItem;
use DeejayPoolBundle\Entity\SvItem;
use DeejayPoolBundle\Entity\FranchisePoolItem;

/**
 * Media
 *
 * @ORM\Table(
 *      indexes={@ORM\Index(name="profider_filename", columns={"providerId", "fileName"})},
 *      uniqueConstraints={@UniqueConstraint(name="full_file_path_md5", columns={"fullFilePathMd5"})},
 *      options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"}
 *
 * )
 * @ORM\Entity(repositoryClass="AudioCoreEntity\Repository\MediaRepository")
 * @UniqueEntity(fields={"provider","fileName"})
 */
class Media
{

    const PROVIDER_DIGITAL_DJ_POOL  = 1;
    const PROVIDER_AV_DISTRICT      = 2;
    const PROVIDER_FRP_AUDIO        = 3;
    const PROVIDER_FRP_VIDEO        = 4;
    const PROVIDER_SMASHVISION      = 5;

    const MEDIA_TYPE_AUDIO          = 1;
    const MEDIA_TYPE_VIDEO          = 2;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"media-read"})
     */
    protected $artist;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"media-read"})
     */
    protected $bpm;
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"media-read"})
     *
     */
    protected $fullPath;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=32, nullable=false)
     * @Groups({"media-read"})
     *
     */
    protected $fullFilePathMd5;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=200, nullable=true)
     * @Groups({"media-read"})
     *
     */
    protected $dirName;


    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"media-read", "artist-read", "genre-read"})
     */
    protected $title;
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"media-read"})
     */
    protected $providerUrl;
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"media-read"})
     */
    protected $releaseDate;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=40, nullable=true)
     * @Groups({"media-read"})
     */
    protected $version;
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"media-read"})
     */
    protected $fileName;
    /**
     * @var string
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default":false})
     * @Groups({"media-read"})
     */
    protected $exist = false;
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default":false})
     * @Groups({"media-read", "genre-read", "artist-read"})
     */
    protected $tagged = false;
    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"media-read"})
     */
    protected $score = 0;
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"media-read"})
     */
    protected $deletedAt;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="medias", cascade={"persist", "detach", "refresh"}, fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="media_genre",
     *      joinColumns={@ORM\JoinColumn(name="media_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="genre_id", referencedColumnName="id")}
     *      )
     * @var ArrayCollection<Genre>
     * @Groups({"media-read"})
     **/
    protected $genres;
    /**
     * @ORM\ManyToMany(targetEntity="Artist", inversedBy="medias", cascade={"persist", "detach", "refresh"}, fetch="EXTRA_LAZY")
     * @ORM\JoinTable(
     *      joinColumns={@ORM\JoinColumn(name="media_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="artist_id", referencedColumnName="id")}
     *      )
     * @var ArrayCollection<Artist>
     * @Groups({"media-read"})
     **/
    protected $artists;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"media-read"})
     */
    protected $type;
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", length=4, nullable=true)
     * @Groups({"media-read", "artist-read", "genre-read"})
     */
    protected $year;
    /**
     * @var integer
     *
     * @ORM\Column(name="provider", type="integer")
     * @Groups({"media-read"})
     */
    protected $provider;
    /**
     * @var integer
     *
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Groups({"media-read"})
     */
    protected $providerId;

    /**
     *
     */
    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->artists = new ArrayCollection();
    }

    public static function getTypes()
    {
        return [
            'audio'         => self::MEDIA_TYPE_AUDIO,
            'video'         => self::MEDIA_TYPE_VIDEO,
        ];
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get artist.
     *
     * @return string
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Set artist.
     *
     * @param string $artist
     *
     * @return Media
     */
    public function setArtist($artist)
    {
        $this->artist = substr(trim($artist), 0, 254);

        return $this;
    }

    /**
     * @return int
     */
    public function getBpm()
    {
        return $this->bpm;
    }

    /**
     * @param int $bpm
     * @return Media
     */
    public function setBpm($bpm)
    {
        $this->bpm = $bpm;
        return $this;
    }

    /**
     * @return string
     */
    public function getExist()
    {
        return $this->exist;
    }

    /**
     * @param string $exist
     * @return $this
     */
    public function setExist($exist)
    {
        $this->exist = $exist;
        return $this;
    }

    /**
     * Get downloadlink.
     *
     * @return string
     */
    public function getProviderUrl()
    {
        return $this->providerUrl;
    }

    /**
     * Set downloadlink.
     *
     * @param string $providerUrl
     *
     * @return Media
     */
    public function setProviderUrl($providerUrl)
    {
        $this->providerUrl = $providerUrl;

        return $this;
    }

    /**
     * Get fullPath.
     *
     * @return string
     */
    public function getFullPath()
    {
        return $this->fullPath;
    }

    /**
     * Set fullPath.
     *
     * @param string $fullPath
     *
     * @return Media
     */
    public function setFullPath($fullPath)
    {
        $pattern = '#('.DIRECTORY_SEPARATOR.')\1+#';
        $replacement = DIRECTORY_SEPARATOR;
        $fullPath = preg_replace($pattern, $replacement, $fullPath);

        $this->fullPath = $fullPath;

        $this->exist = file_exists($fullPath) ? true : true;
        $splFile = new \SplFileInfo($this->fullPath);
        $this->setFileName($splFile->getBasename());
        $this->setFullFilePathMd5(md5($this->fullPath));
        $paths = explode('/', $splFile->getPath());
        $this->setDirName(end($paths));

        return $this;
    }

    /**
     * @return string
     */
    public function getFullFilePathMd5()
    {
        return $this->fullFilePathMd5;
    }

    /**
     * @param string $fullFilePathMd5
     * @return Media
     */
    public function setFullFilePathMd5($fullFilePathMd5)
    {
        $this->fullFilePathMd5 = $fullFilePathMd5;
        return $this;
    }



    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Media
     */
    public function setTitle($title)
    {
        $this->title = trim($title);

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Media
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return int
     */
    public function getProviderId()
    {
        return $this->providerId;
    }

    /**
     * @param int $providerId
     * @return Media
     */
    public function setProviderId($providerId)
    {
        $this->providerId = $providerId;
        return $this;
    }

    /**
     * Get releaseDate.
     *
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set releaseDate.
     *
     * @param \DateTime $releaseDate
     *
     * @return Media
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * @param Genre $genre
     * @return $this
     */
    public function addGenre(Genre $genre)
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
        }
        return $this;
    }

    /**
     * @param Genre $genre
     * @return $this
     */
    public function removeGenre(Genre $genre)
    {
        if ($this->genres->contains($genre)) {
            $this->genres->removeElement($genre);
        }
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getGenres()
    {
        return $this->genres;
    }

    /**
     * @param $genres
     * @return $this
     */
    public function setGenres($genres)
    {
        $this->genres = $genres;

        return $this;
    }
    /**
     * @param Artist $artist
     * @return $this
     */
    public function addArtist(Artist $artist)
    {
        if (!$this->artists->contains($artist)) {
            $this->artists->add($artist);
        }
        return $this;
    }

    /**
     * @param Genre $artist
     * @return $this
     */
    public function removeArtist(Artist $artist)
    {
        if ($this->artists->contains($artist)) {
            $this->artists->removeElement($artist);
        }
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getArtists()
    {
        return $this->artists;
    }

    /**
     * @param $artists
     * @return $this
     */
    public function setArtists($artists)
    {
        $this->genres = $artists;

        return $this;
    }

    /**
     * Get version.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set version.
     *
     * @param string $version
     *
     * @return Media
     */
    public function setVersion($version)
    {
        $this->version = trim($version);

        return $this;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     * @return $this
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
        $this->updateProviderId();
        return $this;
    }

    /**
     * @return string
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param string $score
     * @return Media
     */
    public function setScore($score)
    {
        $this->score = $score;
        return $this;
    }

    /**
     * @return array
     * @Groups({"media-read"})
     */
    public function getProviderCode()
    {
        $key = array_search($this->getProvider(), $this->getProviders());
        return $key;
    }

    /**
     * Get provider
     *
     * @return integer
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set provider
     *
     * @param integer $provider
     * @return Media
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
        $this->updateProviderId();
        return $this;
    }

    public static function getProviders()
    {
        return [
            'av_district'       => self::PROVIDER_AV_DISTRICT,
            'frp_video'         => self::PROVIDER_FRP_VIDEO,
            'frp_audio'         => self::PROVIDER_FRP_AUDIO,
            'ddp'               => self::PROVIDER_DIGITAL_DJ_POOL,
            'sv'                => self::PROVIDER_SMASHVISION,
        ];
    }
    public static function getProviderFromItem($sampleItem)
    {
        $provider = null;
        if ($sampleItem instanceof AvdItem) {
                $provider = Media::PROVIDER_AV_DISTRICT;
        } elseif ($sampleItem instanceof FranchisePoolItem) {
            if ($sampleItem->isAudio()) {
                $provider = Media::PROVIDER_FRP_AUDIO;
            } elseif ($sampleItem->isVideo()) {
                $provider = Media::PROVIDER_FRP_VIDEO;
            }
        } elseif ($sampleItem  instanceof SvItem) {
            $provider = Media::PROVIDER_SMASHVISION;
        }
        return $provider;
    }

    /**
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime $deletedAt
     * @return Media
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getDirName()
    {
        return $this->dirName;
    }

    /**
     * @param string $dirName
     * @return Media
     */
    public function setDirName($dirName)
    {
        $this->dirName = $dirName;
        return $this;
    }

    public function isUntaged() {

        return !$this->tagged;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     * @return Media
     */
    public function setYear($year)
    {
        $this->year = $year;
        return $this;
    }


    /**
     * @return $this
     */
    public function updateProviderId()
    {
        $fileName   = $this->getFileName();
        $provider   = $this->getProvider();
        $patern     = '/^(?P<providerId>\d{1,9})\_/';

        if ($fileName && $provider && in_array($provider, $this->getProviders())) {
            if ($provider === Media::PROVIDER_SMASHVISION) {
                $patern = '/^(?P<providerId>\d{1,9}\_\d{1,9})\_/';
            }

            if (preg_match($patern, $fileName, $matches)){
                $this->setProviderId($matches['providerId']);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getTagged()
    {
        return $this->tagged;
    }

    /**
     * @param bool $tagged
     * @return Media
     */
    public function setTagged($tagged)
    {
        $this->tagged = $tagged;
        return $this;
    }

}
