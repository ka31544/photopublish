<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhotoShoot
 *
 * @ORM\Table(name="photo_shoot")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PhotoShootRepository")
 */
class PhotoShoot
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\OneToMany(targetEntity="PhotosOfPhotoShoot",mappedBy="photoShoot")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var Photo
     *
     * @ORM\ManyToOne(targetEntity="Photo", inversedBy="id")
     */
    private $defaultPhoto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;


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
     * Set name
     *
     * @param string $name
     *
     * @return PhotoShoot
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Photo $defaultPhoto
     */
    public function setDefaultPhoto($defaultPhoto)
    {
        $this->defaultPhoto = $defaultPhoto;
    }

    /**
     * @return Photo
     */
    public function getDefaultPhoto()
    {
        return $this->defaultPhoto;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return PhotoShoot
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}

