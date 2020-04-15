<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RepairRepository")
 */
class Repair
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_supported;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_end;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_delete;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="repairs", cascade={"persist"})
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee", inversedBy="repairs")
     * @ORM\JoinColumn(nullable=true)
     */
    private $emp;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Repstatus", mappedBy="rep", orphanRemoval=true)
     */
    private $repstatuses;

    /**
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private $isActive;
    

    public function __construct()
    {
        $this->setIsActive(true);
        $this->setDateCreate(new \DateTime('now'));
        $this->repstatuses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateSupported(): ?\DateTimeInterface
    {
        return $this->date_supported;
    }

    public function setDateSupported(\DateTimeInterface $date_supported): self
    {
        $this->date_supported = $date_supported;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(?\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getEmp(): ?employee
    {
        return $this->emp;
    }

    public function setEmp(?employee $emp): self
    {
        $this->emp = $emp;

        return $this;
    }

    /**
     * @return Collection|Repstatus[]
     */
    public function getRepstatuses(): Collection
    {
        return $this->repstatuses;
    }

    public function addRepstatus(Repstatus $repstatus): self
    {
        if (!$this->repstatuses->contains($repstatus)) {
            $this->repstatuses[] = $repstatus;
            $repstatus->setRep($this);
        }

        return $this;
    }

    public function removeRepstatus(Repstatus $repstatus): self
    {
        if ($this->repstatuses->contains($repstatus)) {
            $this->repstatuses->removeElement($repstatus);
            // set the owning side to null (unless already changed)
            if ($repstatus->getRep() === $this) {
                $repstatus->setRep(null);
            }
        }

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
