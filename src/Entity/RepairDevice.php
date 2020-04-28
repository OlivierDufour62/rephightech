<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="App\Repository\RepairProviderRepository")
 */
class RepairDevice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\device", cascade={"persist", "remove"})
     */
    private $device;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ServiceProvider", mappedBy="repairProvider")
     */
    private $provider;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\ServiceProvider", inversedBy="repairDevices")
     */
    private $serviceProvider;

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

    public function getDevice(): ?device
    {
        return $this->device;
    }

    public function setDevice(?device $device): self
    {
        $this->device = $device;

        return $this;
    }

    /**
     * @return Collection|ServiceProvider[]
     */
    public function getProvider(): Collection
    {
        return $this->provider;
    }

    public function addProvider(ServiceProvider $provider): self
    {
        if (!$this->provider->contains($provider)) {
            $this->provider[] = $provider;
            $provider->setRepairProvider($this);
        }

        return $this;
    }

    public function removeProvider(ServiceProvider $provider): self
    {
        if ($this->provider->contains($provider)) {
            $this->provider->removeElement($provider);
            // set the owning side to null (unless already changed)
            if ($provider->getRepairProvider() === $this) {
                $provider->setRepairProvider(null);
            }
        }

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
}
