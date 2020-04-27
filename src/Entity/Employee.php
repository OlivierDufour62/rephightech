<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 *  @UniqueEntity(fields={"email", "phonenumber"},
 *     errorPath="port",
 *     message="Email ou numéro de téléphone déjà utilisé."
 * )
 */
class Employee implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Type("string")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Type("string")
     */
    private $phonenumber;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email
     */
    private $email;

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
     * @ORM\Column(type="string", length=255, options={"default": "ROLE_USER"})
     */
    private $role;

    /**
     * @ORM\Column(type="boolean")
     */
    private $genre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Repair", mappedBy="emp")
     */
    private $repairs;

    /**
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    

    public function __construct()
    {
        $this->setRole('ROLE_USER');
        $this->setIsActive(true);
        $this->setDateCreate(new \DateTime('now'));
        $this->date_update = new \DateTime();
        $this->repairs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phonenumber;
    }

    public function setPhoneNumber(string $phonenumber): self
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getDateUptdate(): ?\DateTimeInterface
    {
        return $this->date_update;
    }

    public function setDateUptdate(\DateTimeInterface $date_update): self
    {
        $this->date_update = $date_update;

        return $this;
    }

    public function getDateDelete(): ?\DateTimeInterface
    {
        return $this->date_delete;
    }

    public function setDateDelete(\DateTimeInterface $date_delete): self
    {
        $this->date_delete = $date_delete;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|Repair[]
     */
    public function getRepairs(): Collection
    {
        return $this->repairs;
    }

    public function addRepair(Repair $repair): self
    {
        if (!$this->repairs->contains($repair)) {
            $this->repairs[] = $repair;
            $repair->setEmp($this);
        }

        return $this;
    }

    public function removeRepair(Repair $repair): self
    {
        if ($this->repairs->contains($repair)) {
            $this->repairs->removeElement($repair);
            // set the owning side to null (unless already changed)
            if ($repair->getEmp() === $this) {
                $repair->setEmp(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of genre
     */ 
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set the value of genre
     *
     * @return  self
     */ 
    public function setGenre($genre)
    {
        $this->genre = $genre;

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

    public function getRoles(): array
    {
        $roles = [];
        $roles[] = $this->role;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function getSalt()
    {
        // you may need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getUsername()
    {
        return $this->email;
    }
    
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials()
    {
    }

}
