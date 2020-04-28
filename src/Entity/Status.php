<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\StatusRepository")
 */
class Status
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "En attente"})
     * @Assert\Type("string")
     */
    private $name;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Repair", mappedBy="status")
     */
    private $rep;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Repstatus", mappedBy="status")
     */
    private $repstatuses;

    public function __construct()
    {
        $this->setDateCreate(new \DateTime('now'));
        $this->date_update = new \DateTime();
        $this->rep = new ArrayCollection();
        $this->repstatuses = new ArrayCollection();
        $this->repairs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function setDateUpdate(\DateTimeInterface $date_update): self
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
            $rep->setStatus($this);
        }

        return $this;
    }

    public function removeRep(Repair $rep): self
    {
        if ($this->rep->contains($rep)) {
            $this->rep->removeElement($rep);
            // set the owning side to null (unless already changed)
            if ($rep->getStatus() === $this) {
                $rep->setStatus(null);
            }
        }

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
            $repstatus->setStatus($this);
        }

        return $this;
    }

    public function removeRepstatus(Repstatus $repstatus): self
    {
        if ($this->repstatuses->contains($repstatus)) {
            $this->repstatuses->removeElement($repstatus);
            // set the owning side to null (unless already changed)
            if ($repstatus->getStatus() === $this) {
                $repstatus->setStatus(null);
            }
        }

        return $this;
    }

}
