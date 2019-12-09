<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StatusHistory
 *
 * @ORM\Table(name="status_history")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StatusHistoryRepository")
 */
class StatusHistory
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
     * @var Status
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Status", inversedBy="id")
     */
    private $status;

    /**
     * @var Photo
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Photo", inversedBy="id")
     */
    private $photo;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="id")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * StatusHistory constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime();
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
     * Set status
     *
     * @param Status $status
     *
     * @return StatusHistory
     */
    public function setStatus(Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param Photo $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return Photo
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return StatusHistory
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
