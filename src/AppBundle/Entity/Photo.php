<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Photo
 *
 * @ORM\Table(name="photo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PhotoRepository")
 */
class Photo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\OneToMany(targetEntity="PhotoShoot", mappedBy="defaultPhoto")
     * @ORM\OneToMany(targetEntity="StatusHistory", mappedBy="photo")
     * @ORM\OneToMany(targetEntity="Product", mappedBy="defaultPhoto")
     * @ORM\OneToMany(targetEntity="PhotosOfProduct", mappedBy="photo")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="src", type="string", length=255)
     */
    private $src;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="uploadAt", type="datetime")
     */
    private $uploadAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modifiedAt", type="datetime")
     */
    private $modifiedAt;

    /**
     * @ORM\OneToOne(
     *     targetEntity="PhotosOfPhotoShoot",
     *     mappedBy="photo",
     *     orphanRemoval=true
     * )
     */
    private $photosOfPhotoShoot;

    /**
     * Photo constructor.
     */
    public function __construct()
    {
        $this->photosOfPhotoShoot = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set src
     *
     * @param string $src
     *
     * @return Photo
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get src
     *
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set uploadAt
     *
     * @param \DateTime $uploadAt
     *
     * @return Photo
     */
    public function setUploadAt($uploadAt)
    {
        $this->uploadAt = $uploadAt;

        return $this;
    }

    /**
     * Get uploadAt
     *
     * @return \DateTime
     */
    public function getUploadAt()
    {
        return $this->uploadAt;
    }

    /**
     * Set modifiedAt
     *
     * @param \DateTime $modifiedAt
     *
     * @return Photo
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * @return ArrayCollection
     */
    public function getPhotosOfPhotoShoot()
    {
        return $this->photosOfPhotoShoot;
    }
}

