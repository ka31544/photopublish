<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhotosOfPhotoShoot
 *
 * @ORM\Table(name="photos_of_photo_shoot")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PhotosOfPhotoShootRepository")
 */
class PhotosOfPhotoShoot
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
     * @var Photo
     *
     ** @ORM\OneToOne(targetEntity="Photo",inversedBy="id")
     */
    private $photo;

    /**
     * @var PhotoShoot
     *
     * @ORM\ManyToOne(targetEntity="PhotoShoot",inversedBy="id")
     */
    private $photoShoot;

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
     * Set photo
     *
     * @param integer $photo
     *
     * @return PhotosOfPhotoShoot
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return Photo
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set photoShoot
     *
     * @param integer $photoShoot
     *
     * @return PhotosOfPhotoShoot
     */
    public function setPhotoShoot($photoShoot)
    {
        $this->photoShoot = $photoShoot;

        return $this;
    }

    /**
     * Get photoShoot
     *
     * @return PhotoShoot
     */
    public function getPhotoShoot()
    {
        return $this->photoShoot;
    }
}

