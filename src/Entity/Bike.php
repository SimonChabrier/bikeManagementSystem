<?php

namespace App\Entity;

use App\Repository\BikeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Monolog\DateTimeImmutable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=BikeRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields={"number"}, message="Une vélo porte déja ce numéro !")
 * @UniqueEntity(fields={"reference"}, message="Une vélo porte déjà cette référence !")
 */
class Bike
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     * this is for active or unactive bike
     */
    private $status = true;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $availablity = "Disponible";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $lng;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $rate = 5;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $purchasedAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"number"})
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * Persist file name
     */
    private $mainPicture;

    /**
     * @ORM\ManyToMany(targetEntity=Inventory::class, mappedBy="bikes")
     */
    private $inventories;

    /**
     * @ORM\OneToMany(targetEntity=Vandalism::class, mappedBy="bike")
     */
    private $vandalisms;

    public function __construct()
    {
        $this->inventories = new ArrayCollection();
        $this->vandalisms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMainPicture(): ?string
    {
        return $this->mainPicture;
    }

    public function setMainPicture(?string $mainPicture): self
    {
        $this->mainPicture = $mainPicture;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAvailablity(): ?string
    {
        return $this->availablity;
    }

    public function setAvailablity(string $availablity): self
    {
        $this->availablity = $availablity;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(?string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?string
    {
        return $this->lng;
    }

    public function setLng(?string $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function setRate(string $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getPurchasedAt(): ?\DateTimeImmutable
    {
        return $this->purchasedAt;
    }

    public function setPurchasedAt(?\DateTimeImmutable $purchasedAt): self
    {
        $this->purchasedAt = $purchasedAt;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Inventory>
     */
    public function getInventories(): Collection
    {
        return $this->inventories;
    }

    public function addInventory(Inventory $inventory): self
    {
        if (!$this->inventories->contains($inventory)) {
            $this->inventories[] = $inventory;
            $inventory->addBike($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory): self
    {
        if ($this->inventories->removeElement($inventory)) {
            $inventory->removeBike($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Vandalism>
     */
    public function getVandalisms(): Collection
    {
        return $this->vandalisms;
    }

    public function addVandalism(Vandalism $vandalism): self
    {
        if (!$this->vandalisms->contains($vandalism)) {
            $this->vandalisms[] = $vandalism;
            $vandalism->setBike($this);
        }

        return $this;
    }

    public function removeVandalism(Vandalism $vandalism): self
    {
        if ($this->vandalisms->removeElement($vandalism)) {
            // set the owning side to null (unless already changed)
            if ($vandalism->getBike() === $this) {
                $vandalism->setBike(null);
            }
        }

        return $this;
    }
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps(): void
    {
        $setDateTime = new DateTimeImmutable('now');

        $this->setUpdatedAt($setDateTime);

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt($setDateTime);
        }
    }
}
