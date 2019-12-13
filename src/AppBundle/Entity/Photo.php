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
     * @ORM\Column(name="uploadAt", type="datetime", nullable=true)
     */
    private $uploadAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modifiedAt", type="datetime", nullable=true)
     */
    private $modifiedAt;

    /**
     * @var Status
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Status", inversedBy="id")
     */
    private $activeStatus;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="id")
     * @ORM\JoinColumn(name="assigned_photographer", referencedColumnName="id")
     */
    private $assignedPhotographer;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="id")
     * @ORM\JoinColumn(name="assigned_retoucher", referencedColumnName="id", nullable=true)
     */
    private $assignedRetoucher;

    /**
     * @ORM\OneToOne(
     *     targetEntity="PhotosOfPhotoShoot",
     *     mappedBy="photo",
     *     orphanRemoval=true
     * )
     */
    private $photosOfPhotoShoot;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\StatusHistory",
     *     mappedBy="photo",
     *     orphanRemoval=true
     * )
     */
    private $photoStatusHistory;

    /**
     * Photo constructor.
     */
    public function __construct()
    {
        $this->photoStatusHistory = new ArrayCollection();
        $this->uploadAt = new \DateTime();
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
     * @param Status $activeStatus
     */
    public function setActiveStatus($activeStatus)
    {
        $this->activeStatus = $activeStatus;
    }

    /**
     * @return Status
     */
    public function getActiveStatus()
    {
        return $this->activeStatus;
    }

    /**
     * @param User $assignedPhotographer
     */
    public function setAssignedPhotographer($assignedPhotographer)
    {
        $this->assignedPhotographer = $assignedPhotographer;
    }

    /**
     * @return User
     */
    public function getAssignedPhotographer()
    {
        return $this->assignedPhotographer;
    }

    /**
     * @param User $assignedRetoucher
     */
    public function setAssignedRetoucher($assignedRetoucher)
    {
        $this->assignedRetoucher = $assignedRetoucher;
    }

    /**
     * @return User
     */
    public function getAssignedRetoucher()
    {
        return $this->assignedRetoucher;
    }

    /**
     * @return ArrayCollection
     */
    public function getPhotosOfPhotoShoot()
    {
        return $this->photosOfPhotoShoot;
    }

    /**
     * @return ArrayCollection
     */
    public function getPhotoStatusHistory()
    {
        return $this->photoStatusHistory;
    }
}

