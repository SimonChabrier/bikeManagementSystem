<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\BikeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Monolog\DateTimeImmutable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 * paginationEnabled=false,
 * collectionOperations={"get"},
 * itemOperations={"get"},
 * normalizationContext={"groups"={"bike:get"}},
 * )
 * 
 * 
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
     * @Groups("bike:get")
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     * this is for active or unactive bike
     * 
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=30)
     * 
     */
    private $availablity = "Disponible";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * 
     */
    private $lat;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * 
     */
    private $lng;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * 
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=4)
     * @Groups("bike:get")
     * @Groups("station:get")
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=1)
     * 
     */
    private $rate = 5;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * 
     */
    private $purchasedAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"number"})
     * 
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Gedmo\Timestampable(on="create")
     * 
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     * 
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * Persist file name
     * 
     */
    private $mainPicture;

    /**
     * @ORM\ManyToMany(targetEntity=Inventory::class, mappedBy="bikes")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     * 
     */
    private $inventories;

    /**
     * @ORM\OneToMany(targetEntity=Vandalism::class, mappedBy="bike")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     * 
     */
    private $vandalisms;

    /**
     * @ORM\OneToMany(targetEntity=RepairAct::class, mappedBy="bike")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     * 
     */
    private $repairs;

    /**
     * @ORM\OneToMany(targetEntity=Balance::class, mappedBy="bike")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     * 
     */
    private $balances;

    public function __construct()
    {
        $this->inventories = new ArrayCollection();
        $this->vandalisms = new ArrayCollection();
        $this->repairs = new ArrayCollection();
        $this->balances = new ArrayCollection();
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
     * @return Collection<int, RepairAct>
     */
    public function getRepairs(): Collection
    {
        return $this->repairs;
    }

    public function addRepair(RepairAct $repair): self
    {
        if (!$this->repairs->contains($repair)) {
            $this->repairs[] = $repair;
            $repair->setBike($this);
        }

        return $this;
    }

    public function removeRepair(RepairAct $repair): self
    {
        if ($this->repairs->removeElement($repair)) {
            // set the owning side to null (unless already changed)
            if ($repair->getBike() === $this) {
                $repair->setBike(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Balance>
     */
    public function getBalances(): Collection
    {
        return $this->balances;
    }

    public function addBalance(Balance $balance): self
    {
        if (!$this->balances->contains($balance)) {
            $this->balances[] = $balance;
            $balance->setBike($this);
        }

        return $this;
    }

    public function removeBalance(Balance $balance): self
    {
        if ($this->balances->removeElement($balance)) {
            // set the owning side to null (unless already changed)
            if ($balance->getBike() === $this) {
                $balance->setBike(null);
            }
        }

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    // public function updatedTimestamps(): void
    // {
    //     $setDateTime = new DateTimeImmutable('now');

    //     $this->setUpdatedAt($setDateTime);

    //     if ($this->getCreatedAt() === null) {
    //         $this->setCreatedAt($setDateTime);
    //     }
    // }
}
