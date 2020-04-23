<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="App\Repository\DeviceRepository")
 */
class Device
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $refDevice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mark;

    /**
     * @ORM\Column(type="boolean")
     */
    private $guarantee;

    /**
     * @ORM\Column(type="boolean")
     */
    private $beSame;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Repair", mappedBy="device", cascade={"persist"})
     */
    private $rep;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ServiceProvider", mappedBy="device")
     */
    private $serviceProviders;

    public function __construct()
    {
        $this->setDateCreate(new \DateTime('now'));
        $this->date_update = new \DateTime();
        $this->rep = new ArrayCollection();
        $this->serviceProviders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getRefDevice(): ?string
    {
        return $this->refDevice;
    }

    public function setRefDevice(string $refDevice): self
    {
        $this->refDevice = $refDevice;

        return $this;
    }

    public function getMark(): ?string
    {
        return $this->mark;
    }

    public function setMark(string $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getGuarantee(): ?bool
    {
        return $this->guarantee;
    }

    public function setGuarantee(bool $guarantee): self
    {
        $this->guarantee = $guarantee;

        return $this;
    }

    public function getBeSame(): ?bool
    {
        return $this->beSame;
    }

    public function setBeSame(bool $beSame): self
    {
        $this->beSame = $beSame;

        return $this;
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

    /**
     * @return Collection|Repair[]
     */
    public function getRep(): Collection
    {
        return $this->rep;
    }

    public function addRep(Repair $rep): self
    {
        if (!$this->rep->contains($rep)) {
            $this->rep[] = $rep;
            $rep->setDevice($this);
        }

        return $this;
    }

    public function removeRep(Repair $rep): self
    {
        if ($this->rep->contains($rep)) {
            $this->rep->removeElement($rep);
            // set the owning side to null (unless already changed)
            if ($rep->getDevice() === $this) {
                $rep->setDevice(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ServiceProvider[]
     */
    public function getServiceProviders(): Collection
    {
        return $this->serviceProviders;
    }

    public function addServiceProvider(ServiceProvider $serviceProvider): self
    {
        if (!$this->serviceProviders->contains($serviceProvider)) {
            $this->serviceProviders[] = $serviceProvider;
            $serviceProvider->setDevice($this);
        }

        return $this;
    }

    public function removeServiceProvider(ServiceProvider $serviceProvider): self
    {
        if ($this->serviceProviders->contains($serviceProvider)) {
            $this->serviceProviders->removeElement($serviceProvider);
            // set the owning side to null (unless already changed)
            if ($serviceProvider->getDevice() === $this) {
                $serviceProvider->setDevice(null);
            }
        }

        return $this;
    }
}
