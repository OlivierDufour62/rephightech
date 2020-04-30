<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="App\Repository\RepairProviderRepository")
 */
class ProviderDevice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @var \DateTime $date_create
    *
    * @Gedmo\Timestampable(on="create")
    * @ORM\Column(type="datetime")
    */
    private $date_create;

    /**
     * @var \DateTime $date_update
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $date_update;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_delete;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_send;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ServiceProvider", inversedBy="providerDevices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serviceProvider;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Device", inversedBy="providerDevice")
     * @ORM\JoinColumn(nullable=false)
     */
    private $device;

    private $repair_id;

    public function __construct()
    {
        $this->setDateCreate(new \DateTime('now'));
        $this->date_update = new \DateTime();
        $this->provider = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->date_create;
    }

    public function setDateCreate(\DateTimeInterface $date_create): self
    {
        $this->date_create = $date_create;

        return $this;
    }

    public function getDateUpdate(): ?\DateTimeInterface
    {
        return $this->date_update;
    }

    public function setDateUpdate(?\DateTimeInterface $date_update): self
    {
        $this->date_update = $date_update;

        return $this;
    }

    public function getDateDelete(): ?\DateTimeInterface
    {
        return $this->date_delete;
    }

    public function setDateDelete(?\DateTimeInterface $date_delete): self
    {
        $this->date_delete = $date_delete;

        return $this;
    }

    public function getDateSend(): ?\DateTimeInterface
    {
        return $this->date_send;
    }

    public function setDateSend(?\DateTimeInterface $date_send): self
    {
        $this->date_send = $date_send;

        return $this;
    }

    public function getServiceProvider(): ?ServiceProvider
    {
        return $this->serviceProvider;
    }

    public function setServiceProvider(?ServiceProvider $serviceProvider): self
    {
        $this->serviceProvider = $serviceProvider;

        return $this;
    }

    public function getDevice(): ?Device
    {
        return $this->device;
    }

    public function setDevice(?Device $device): self
    {
        $this->device = $device;

        return $this;
    }

    /**
     * Get the value of repair_id
     */ 
    public function getRepairId()
    {
        return $this->repair_id;
    }

    /**
     * Set the value of repair_id
     *
     * @return  self
     */ 
    public function setRepairId($repair_id)
    {
        $this->repair_id = $repair_id;

        return $this;
    }
}
