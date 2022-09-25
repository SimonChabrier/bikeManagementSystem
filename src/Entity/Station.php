<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\StationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;;
use Monolog\DateTimeImmutable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 * paginationEnabled=false,
 * collectionOperations={"get"},
 * itemOperations={"get"},
 * normalizationContext={"groups"={"station:get"}},
 * )
 * 
 * @ORM\Entity(repositoryClass=StationRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields={"name"}, message="Une station porte déjà ce nom !")
 * @UniqueEntity(fields={"reference"}, message="Une station porte déjà cette référence !")
 */
class Station
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("station:get")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     * this is for active or unactive a Station
     */
    private $status = true;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     * this is for station external reference number from client
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * this is for station internal reference
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     * this is for station item capacity from 0 to 999
     */
    private $capacity;

    /**
     * 
     * @ORM\Column(type="string", length=150)
     * @Groups("station:get")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $zip;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $lng;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * Persist file name
     */
    private $mainPicture;

    /**
     * @ORM\OneToMany(targetEntity=Inventory::class, mappedBy="station")
    */
    private $inventories;

    /**
     * @ORM\OneToMany(targetEntity=Vandalism::class, mappedBy="station")
     */
    private $vandalisms;

    /**
     * @ORM\OneToMany(targetEntity=RepairAct::class, mappedBy="station")
     */
    private $repairs;

    /**
     * @ORM\ManyToMany(targetEntity=Balance::class, mappedBy="stations")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

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

    public function getCapacity(): ?string
    {
        return $this->capacity;
    }

    public function setCapacity(string $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
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

    public function getMainPicture(): ?string
    {
        return $this->mainPicture;
    }

    public function setMainPicture(?string $mainPicture): self
    {
        $this->mainPicture = $mainPicture;

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
            $inventory->setStation($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory): self
    {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getStation() === $this) {
                $inventory->setStation(null);
            }
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
            $vandalism->setStation($this);
        }

        return $this;
    }

    public function removeVandalism(Vandalism $vandalism): self
    {
        if ($this->vandalisms->removeElement($vandalism)) {
            // set the owning side to null (unless already changed)
            if ($vandalism->getStation() === $this) {
                $vandalism->setStation(null);
            }
        }

        return $this;
    }

    /**
     * Property to string used ti display converted object value to a string value
     * Used in Forms using EntityType::class for exemple
     * or in Views if need.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
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
            $repair->setStation($this);
        }

        return $this;
    }

    public function removeRepair(RepairAct $repair): self
    {
        if ($this->repairs->removeElement($repair)) {
            // set the owning side to null (unless already changed)
            if ($repair->getStation() === $this) {
                $repair->setStation(null);
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
            $balance->addStation($this);
        }

        return $this;
    }

    public function removeBalance(Balance $balance): self
    {
        if ($this->balances->removeElement($balance)) {
            $balance->removeStation($this);
        }

        return $this;
    }


}
