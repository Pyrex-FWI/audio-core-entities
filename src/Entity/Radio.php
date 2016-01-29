<?php

namespace AudioCoreEntity\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Radio.
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity("name")
 */
class Radio
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var array
     *
     * @ORM\Column(name="hitPages", type="json_array")
     */
    private $hitPages;

    public function __construct()
    {
        $this->hitPages = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Radio
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set hitPages.
     *
     * @param array $hitPages
     *
     * @return Radio
     */
    public function setHitPages($hitPages)
    {
        $this->hitPages = $hitPages;

        return $this;
    }

    /**
     * Get hitPages.
     *
     * @return array
     */
    public function getHitPages()
    {
        return $this->hitPages;
    }
}
